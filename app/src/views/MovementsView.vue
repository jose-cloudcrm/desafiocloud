<template>
    <div>
        <h1>Cadastro de Movimentações</h1>
        <form @submit.prevent="register">
            <div class="form-group">
                <label for="produto">Produto</label>
                <select v-model="dataMovem.produtos_id" class="form-control mb-3" name="produto" multiple required>
                    <option value="" disabled>Escolha um ou mais produtos</option>
                    <option v-for="produto in Produtos" :key="produto.id" :value="produto.id">
                        {{ produto.id }} - {{ produto.name }} - {{ produto.quantidade }} unidades - R$ {{ produto.valor }}
                    </option>
                </select>
            </div>
            <div class="form-group">
                <label for="user">Usuário</label>
                <select v-model="dataMovem.usuario_id" class="form-control mb-3" name="user" required>
                    <option value="" disabled selected>Escolha um usuário</option>
                    <option v-for="account in accounts" :key="account.id" :value="account.id">
                        {{ account.id }} - {{ account.name }} - {{ account.email }}
                    </option>
                </select>
            </div>
            <div class="form-group">
                <label for="">Tipo de Pagamento</label>
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
</template>

<script>
import axios from "axios";

export default {
    name: 'UserCreateView',
    data() {
        return {
            dataMovem: {
                produtos_id: [],
                usuario_id: '',
                tipoDePagamento: '',
                bloqueado: false
            },
            Produtos: [],
            accounts: [],
            successMessage: '',
            errorMessage: ''
        }
    },
    methods: {
        async register() {
            try {
                const movementData = {
                    ...this.dataMovem,
                    bloqueado: !!this.dataMovem.bloqueado
                };

                await axios.post('/movements', movementData);
                this.resetForm();
                this.successMessage = 'Movimentação cadastrada com sucesso!';
                this.errorMessage = '';
                setTimeout(() => {
                    this.successMessage = '';
                }, 3000);
            } catch (error) {
                console.error('Erro ao cadastrar a Movimentação:', error);
                this.errorMessage = 'Ocorreu um erro ao cadastrar. Tente novamente.';
            }
        },
        resetForm() {
            this.dataMovem = {
                produtos_id: [],
                usuario_id: '',
                tipoDePagamento: '',
                bloqueado: false
            };
        },
        async getAccounts() {
            try {
                const response = await axios.get('/users');
                this.accounts = response.data.users;
            } catch (error) {
                console.error('Erro ao buscar contas:', error);
            }
        },
        async getProdutos() {
            try {
                const resp = await axios.get('/produtos');
                this.Produtos = resp.data;
            } catch (error) {
                console.error('Erro ao buscar produtos:', error);
            }
        }
    },
    created() {
        this.getAccounts();
        this.getProdutos();
    }
}
</script>


<style scoped>
h1 {
    color: white;
    text-align: center;
    margin-left: 400px;

}

form {
    background-color: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
    width: 100%;
    min-width: 600px;
    max-width: 800px;
    margin: 0 auto;
    margin-left: 400px;
}

label {
    color: black;
}

.text-success {
    color: green;
    text-align: center;
    font-weight: bold;
}

.text-danger {
    color: red;
    text-align: center;
    font-weight: bold;
}
</style>
