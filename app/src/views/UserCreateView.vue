<template>
    <div>
        <h1>Cadastro de Usuario</h1>
        <form @submit.prevent="create">
            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" class="form-control mb-3" name="name" id="name" v-model="dataForm.name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control mb-3" name="email" id="email" v-model="dataForm.email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control mb-3" name="password" id="password" v-model="dataForm.password" required>
            </div>
            <div class="form-group">
                <label for="birthday">Data de Aniversário</label>
                <input type="date" class="form-control mb-3" name="birthday" id="birthday" v-model="dataForm.birthday" required>
            </div>
            <button type="submit" class="btn btn-primary" @click="register()">Submit</button>
            <p v-if="successMessage" class="text-success mt-3">{{ successMessage }}</p>
            <p v-if="errorMessage" class="text-danger mt-3">{{ errorMessage }}</p>
            <p v-if="emailErrorMessage" class="text-danger mt-3">{{ emailErrorMessage }}</p>
        </form>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: 'UserCreateView',
    data() {
        return {
            dataForm: {
                name: '',
                email: '',
                password: '',
                birthday: ''
            },
            successMessage: '',
            errorMessage: '',
            emailErrorMessage: ''
        }
    },
    methods: {
        register() {
            if (!this.isOfAge(this.dataForm.birthday)) {
                this.errorMessage = 'Você precisa ter mais de 18 anos para se cadastrar.';
                return;
            }

            if (this.dataForm.password.length < 6) {
                this.errorMessage = 'A senha deve ter mais de 6 caracteres.';
                return;
            }

            axios.get('/users/checkemail', { params: { email: this.dataForm.email } }).then((response) => {

                    if (response.data.exists) {

                        this.emailErrorMessage = 'E-mail já cadastrado!';

                    } else {
                        axios.post('/users', this.dataForm)
                            .then(() => {
                                this.resetForm();
                                this.successMessage = 'Usuário cadastrado com sucesso!';
                                this.errorMessage = '';
                                setTimeout(() => {
                                    this.successMessage = '';
                                }, 3000);
                            })
                            .catch(error => {
                                console.error('Erro ao cadastrar usuário:', error);
                                this.errorMessage = 'Ocorreu um erro ao cadastrar. Tente novamente.';
                            });
                    }
                })
                .catch(error => {
                    console.error('Erro ao verificar e-mail:', error);
                    this.errorMessage = 'Erro ao verificar e-mail. Tente novamente.';
                });
        },
        isOfAge(birthday) {
            const birthDate = new Date(birthday);
            const today = new Date();
            const idade = today.getFullYear() - birthDate.getFullYear();
            const mes = today.getMonth() - birthDate.getMonth();
            const dayDiff = today.getDate() - birthDate.getDate();

            return idade > 18 || (idade === 18 && (mes > 0 || (mes === 0 && dayDiff >= 0)));
        },
        resetForm() {
            this.dataForm = {
                name: '',
                email: '',
                password: '',
                birthday: ''
            };
        }
    }
}
</script>


<style scoped>
h1 {
    color: white;
    text-align: center;
    margin-left: 450px;
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
