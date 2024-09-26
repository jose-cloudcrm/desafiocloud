<template>
    <div v-if="user" class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Usuário: {{ user.id }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="updateUser">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="name" v-model="user.name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" v-model="user.email" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="password" v-model="user.password" required>
                        </div>
                        <div class="mb-3">
                            <label for="birthday" class="form-label">Data de Aniversário</label>
                            <input type="date" class="form-control" id="birthday" v-model="user.birthday" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Salvar</button>
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
    selectedUser: Object
});

const user = ref({ ...props.selectedUser });

watch(() => props.selectedUser, (newUser) => {
    user.value = { ...newUser };
});

const updateUser = () => {
    if (user.value && user.value.id) {
        const senha = user.value.password;
        if(senha && senha.length >= 6){
            axios.put(`users/${user.value.id}`, user.value).then(response => {
                alert('Usuário atualizado com sucesso!');
                window.location.reload();
            }).catch(error => {
                alert('Preencha os campos corretamente');
                console.error('Erro ao atualizar o usuário:', error);
                });
        } else {
            alert('Senha deve ter mais de 6 caracteres');
        }
    } else {
        console.error('ID indefinido para o usuário');
    }
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
