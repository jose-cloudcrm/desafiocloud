<template>
    <div v-if="user" class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import axios from 'axios';

const props = defineProps({
    createUser: Object
});

const user = ref({ ...props.createUser });

watch(() => props.createUser, (newUser) => {
    user.value = { ...newUser };
});

const dataForm = ref({
  name: '',
  email: '',
  password: '',
  birthday: ''
});

const successMessage = ref('');
const errorMessage = ref('');
const emailErrorMessage = ref('');

const register = async () => {
  if (!isOfAge(dataForm.value.birthday)) {
    errorMessage.value = 'Você precisa ter mais de 18 anos para se cadastrar.';
    return;
  }

  if (dataForm.value.password.length < 6) {
    errorMessage.value = 'A senha deve ter mais de 6 caracteres.';
    return;
  }

  try {
    const response = await axios.get('/users/checkemail', { params: { email: dataForm.value.email } });
    if (response.data.exists) {
      emailErrorMessage.value = 'E-mail já cadastrado!';
    } else {
      await axios.post('/users', dataForm.value);
      resetForm();
      successMessage.value = 'Usuário cadastrado com sucesso!';
      errorMessage.value = '';
      setTimeout(() => {
        successMessage.value = '';
      }, 3000);
    }
  } catch (error) {
    console.error('Erro ao cadastrar/verificar e-mail:', error);
    errorMessage.value = 'Erro ao cadastrar ou verificar e-mail. Tente novamente.';
  }
};

const isOfAge = (birthday) => {
  const birthDate = new Date(birthday);
  const today = new Date();
  const idade = today.getFullYear() - birthDate.getFullYear();
  const mes = today.getMonth() - birthDate.getMonth();
  const dayDiff = today.getDate() - birthDate.getDate();

  return idade > 18 || (idade === 18 && (mes > 0 || (mes === 0 && dayDiff >= 0)));
};

const resetForm = () => {
  dataForm.value = {
    name: '',
    email: '',
    password: '',
    birthday: ''
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
