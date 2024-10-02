<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <button type="button" class="btn btn-success btncriaruser me-auto" data-bs-toggle="modal" data-bs-target="#createUserModal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-plus" viewBox="0 0 16 16">
                        <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                        <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5"/>
                    </svg>
                </button>
                <form class="d-flex" @submit.prevent="PesquisarId">
                    <input class="form-control me-2" type="search" placeholder="Buscar por ID" v-model="buscarid">
                    <button class="btn btn-outline-success" type="submit">Buscar</button>
                </form>
            </div>
        </div>
    </nav>
    <table class="table table-striped table-dark tabela">
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Nome</th>
                <th scope="col">Email</th>
                <th scope="col">Data de aniversário</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="user in users.users" :key="user.id">
                <th scope="row">{{ user.id }}</th>
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
                <td>{{ user.birthday }}</td>
                <td>
                    <button type="button" class="btn btn-warning" @click="editUser(user)" data-bs-toggle="modal" data-bs-target="#editUserModal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                        </svg>
                    </button>
                    <button type="button" class="btn btn-danger" @click="deleteUser(user.id)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                        </svg>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>

    <EditUser :selectedUser="selectedUser" />
    <UserCreateModal :createUser="createUser" />
</template>

<script setup>
import axios from 'axios';
import { ref } from 'vue';
import EditUser from './modals/EditUser.vue';
import UserCreateModal from './modals/UserCreateModal.vue';

const users = ref([]);
const buscarid = ref('');
const selectedUser = ref(null);
const createUser = ref(null);

axios.get('users').then((response) => {
    users.value = response.data;
}).catch(error => {
    console.log(error);
});

const PesquisarId = () => {
    if(buscarid.value) {
        axios.get(`users/${buscarid.value}`).then((response) => {
            const newResponse = {
                status: response.data.status,

                users: [response.data.users]

            };
            console.log(response.data)
            users.value = newResponse;
        }).catch(error => {
            console.log(error);
            alert('Usuario não encontrado!');
        });
    } else {
        if(!buscarid.value) {
            window.location.reload();
        }
    }
};

const deleteUser = (id) => {
    if(confirm("Tem certeza que deseja deletar esse usuário?")) {
        axios.delete(`users/${id}`).then(() => {
            window.location.reload();
        }).catch(error => {
            console.log(error);
            alert('Usuario Possui uma Movimentação');
        });
    }
};

const editUser = (user) => {
    console.log(user)
    selectedUser.value = user;
    console.log(selectedUser)
};
</script>


<style lang="css" scoped>
nav{
    min-width: 700px;
    max-width: 900px;
    margin-left: 300px;
    padding-left: 700px;
}

.tabela{
    width: 100%;
    max-width: 900px;
    min-width: 200px;
    margin-left: 300px;
}

button {
    width: 40%;
}

.btncriaruser{
    margin-left: -700px;
}
</style>