<template>
    <div v-if="produto" class="modal fade" id="createProdutoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Criar Usuário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="create">
                        <div class="form-group">
                            <label for="name">Nome</label>
                            <input type="text" class="form-control mb-3" name="name" id="name" required v-model="dataProd.name">
                        </div>
                        <div class="form-group">
                            <label for="quantidade">Quantidade</label>
                            <input type="number" class="form-control mb-3" name="quantidade" id="quantidade" v-model="dataProd.quantidade" required>
                        </div>
                        <div class="form-group">
                            <label for="valor">Valor Unitario</label>
                            <input type="number" class="form-control mb-3" name="valor" id="valor" placeholder="R$ 0,00" v-model="dataProd.valor_unitario" required>
                        </div>
                        <button type="submit" class="btn btn-primary" @click="register()">Submit</button>
                        <p v-if="successMessage" class="text-success mt-3">{{ successMessage }}</p>
                        <p v-if="errorMessage" class="text-danger mt-3">{{ errorMessage }}</p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import axios from 'axios';

const props = defineProps({
    selectedProdutos: Object
});

const produto = ref({ ...props.selectedProdutos });

watch(() => props.selectedProdutos, (newProduto) => {
    produto.value = { ...newProduto };
});

const dataProd = ref({
  name: '',
  quantidade: '',
  valor_unitario: ''
});

const successMessage = ref('');
const errorMessage = ref('');

const register = () => {
  axios.post('/produtos', dataProd.value)
    .then(() => {
      resetForm();
      successMessage.value = 'Produto cadastrado com sucesso!';
      errorMessage.value = '';
      setTimeout(() => {
        successMessage.value = '';
      }, 3000);
    })
    .catch(error => {
      console.error('Erro ao cadastrar Produto:', error);
      errorMessage.value = 'Ocorreu um erro ao cadastrar. Tente novamente.';
    });
};

const resetForm = () => {
  dataProd.value = {
    name: '',
    quantidade: '',
    valor: ''
  };
};
</script>

<style scoped>
h5{
    color: black;
}
label{
    color: black;
}
.modal-body {
    padding: 20px;
}
</style>
