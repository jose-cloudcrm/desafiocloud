<template>
    <div class="modal fade" id="createMoveModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Criar Movimentação</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="register">
                        <div class="form-group">
                            <label for="produto">Produtos</label>
                            <div class="table-responsive" style="max-height: 300px; overflow-y: scroll;">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Selecionar</th>
                                            <th>ID</th>
                                            <th>Nome</th>
                                            <th>Quantidade</th>
                                            <th>Valor</th>
                                            <th>Quantidade Desejada</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="produto in Produtos" :key="produto.id">
                                            <td>
                                                <input type="checkbox" v-model="dataMovem.produtos_id" :value="produto.id">
                                            </td>
                                            <td>{{ produto.id }}</td>
                                            <td>{{ produto.name }}</td>
                                            <td>{{ produto.quantidade }} unidades</td>
                                            <td>R$ {{ produto.valor_total}}</td>
                                            <td>
                                                <input type="number" v-model.number="produto.quantidadeSelecionada" :max="produto.quantidade" class="form-control" :placeholder="'Máximo: ' + produto.quantidade" :disabled="!dataMovem.produtos_id.includes(produto.id)">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="user">Usuário</label>
                            <select v-model="dataMovem.usuario_id" class="form-control mb-3" name="user" required>
                                <option value="" disabled selected>Escolha um usuário</option>
                                <option v-for="account in accounts" :key="account.id" :value="account.id">
                                    {{ account.name }} - {{ account.email }}
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tipoDePagamento">Tipo de Pagamento</label>
                            <select v-model="dataMovem.tipoDePagamento" class="form-control mb-3" name="tipoDePagamento" required>
                                <option value="" disabled selected>Escolha um Tipo de Pagamento</option>
                                <option value="credito">Crédito</option>
                                <option value="debito">Débito</option>
                            </select>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" v-model="dataMovem.bloqueado" type="checkbox" id="flexCheckChecked">
                            <label class="form-check-label mb-3" for="flexCheckChecked">
                                Bloqueado
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <p v-if="successMessage" class="text-success mt-3">{{ successMessage }}</p>
                        <p v-if="errorMessage" class="text-danger mt-3">{{ errorMessage }}</p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const dataMovem = ref({
  produtos_id: [],
  usuario_id: '',
  tipoDePagamento: '',
  bloqueado: false
});

const Produtos = ref([]);
const accounts = ref([]);
const successMessage = ref('');
const errorMessage = ref('');

const register = async () => {
  try {
    const selectedProducts = Produtos.value
      .filter(produto => dataMovem.value.produtos_id.includes(produto.id))
      .map(produto => ({
        produto_id: produto.id,
        quantidade: produto.quantidadeSelecionada
      }));

    const movementData = {
      ...dataMovem.value,
      produtos: selectedProducts,
      bloqueado: !!dataMovem.value.bloqueado
    };

    await axios.post('/movementproducts', movementData);

    selectedProducts.forEach(selectedProduct => {
      const produto = Produtos.value.find(p => p.id === selectedProduct.produto_id);
      produto.quantidade -= selectedProduct.quantidade;
    });

    resetForm();
    successMessage.value = 'Movimentação cadastrada com sucesso!';
    errorMessage.value = '';
    setTimeout(() => {
      successMessage.value = '';
    }, 3000);
  } catch (error) {
    console.error('Erro ao cadastrar a Movimentação:', error);
    errorMessage.value = 'Ocorreu um erro ao cadastrar. Tente novamente.';
  }
};

const resetForm = () => {
  dataMovem.value = {
    produtos_id: [],
    usuario_id: '',
    tipoDePagamento: '',
    bloqueado: false
  };
};

const getAccounts = async () => {
  try {
    const response = await axios.get('/users');
    accounts.value = response.data.users;
  } catch (error) {
    console.error('Erro ao buscar contas:', error);
  }
};

const getProdutos = async () => {
  try {
    const resp = await axios.get('/produtos');
    Produtos.value = resp.data.map(produto => ({ ...produto, quantidadeSelecionada: 0 }));
  } catch (error) {
    console.error('Erro ao buscar produtos:', error);
  }
};

onMounted(() => {
  getAccounts();
  getProdutos();
});
</script>

<style scoped>

</style>