<template>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <button type="button" class="btn btn-success btncriarprodutos me-auto" data-bs-toggle="modal" data-bs-target="#createProdutoModal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-seam" viewBox="0 0 16 16">
                        <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2zm3.564 1.426L5.596 5 8 5.961 14.154 3.5zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464z"/>
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
                <th scope="col">Quantidade</th>
                <th scope="col">Valor</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="produto in produtos" :key="produto.id">
                <th scope="row">{{ produto.id }}</th>
                <td>{{ produto.name }}</td>
                <td>{{ produto.quantidade }}</td>
                <td>R$ {{ produto.valor_total }}</td>
                <td>
                    <button type="button" class="btn btn-warning" @click="editProdutos(produto)" data-bs-toggle="modal" data-bs-target="#editProdutoModal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                        </svg>
                    </button>
                    <button type="button" class="btn btn-danger" @click="deleteProdutos(produto.id)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                        </svg>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>

        <ProdutoCreateModal :selectedProdutos ="selectedProdutos" />
        <EditProdutoModal :editProduto ="editProduto" />
</template>

<script setup>
import axios from 'axios';
import { ref } from 'vue';
import ProdutoCreateModal from './modals/ProdutoCreateModal.vue';
import EditProdutoModal from './modals/EditProdutoModal.vue';


const produtos = ref([]);
const selectedProdutos = ref(null);
const buscarid = ref('');
const editProduto = ref(null);

axios.get('produtos').then((response) => {
    produtos.value = response.data;
}).catch(error => {
    console.log(error);
});

const PesquisarId = () => {
    if(buscarid.value !== '') {
        axios.get(`produtos/${buscarid.value}`).then((response) => {
            produtos.value = [response.data];
        }).catch(error => {
            console.log(error);
            alert('Produto não encontrado!');
        });
    } else {
        window.location.reload();
    }
};

const deleteProdutos = (id) => {
    if(confirm("Tem certeza que deseja deletar esse produto?")) {
        axios.delete(`produtos/${id}`).then(() => {
            window.location.reload();
        }).catch(error => {
            console.log(error);
        });
    }
};

const editProdutos = (produto) => {
    editProduto.value = produto;
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

.btncriarprodutos{
    margin-left: -700px;
}
</style>