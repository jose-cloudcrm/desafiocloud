<template>
    <div>
        <h1>Cadastro de Produto</h1>
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
                <label for="valor">Valor</label>
                <input type="number" class="form-control mb-3" name="valor" id="valor" placeholder="R$ 0,00" v-model="dataProd.valor" required>
            </div>
            <button type="submit" class="btn btn-primary" @click="register()">Submit</button>
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
            dataProd: {
                name: '',
                quantidade: '',
                valor: ''
            },
            successMessage: '',
            errorMessage: ''
        }
    },
    methods: {
        register() {
                axios.post('/produtos', this.dataProd)
                            .then(() => {
                                this.resetForm();
                                this.successMessage = 'Produto cadastrado com sucesso!';
                                this.errorMessage = '';
                                setTimeout(() => {
                                    this.successMessage = '';
                                }, 3000);
                            }).catch(error => {
                                console.error('Erro ao cadastrar Produto:', error);
                                this.errorMessage = 'Ocorreu um erro ao cadastrar. Tente novamente.';
                            });
                },
                resetForm() {
                    this.dataProd = {
                        name: '',
                        quantidade: '',
                        valor: ''
                    };
            }
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
