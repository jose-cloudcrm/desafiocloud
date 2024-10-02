<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <button type="button" class="btn btn-success btncriaruser me-auto" data-bs-toggle="modal" data-bs-target="#createMoveModal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-layout-text-sidebar" viewBox="0 0 16 16">
                        <path d="M3.5 3a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1zM3 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m.5 2.5a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1z"/>
                        <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm12-1v14h2a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zm-1 0H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h9z"/>
                    </svg>
                </button>
                <form class="d-flex" @submit.prevent="Pesquisartp">
                    <input class="form-control me-2" type="search" placeholder="Buscar por Pagamento" v-model="buscartp">
                    <button class="btn btn-outline-success buttonform" type="submit">Buscar</button>
                </form>
            </div>
        </div>
    </nav>

    <table class="table table-striped table-dark tabela">
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Usuario</th>
                <th scope="col">Produtos</th>
                <th scope="col">Tipo De Pagamento</th>
                <th scope="col">Valor</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="movement in movements.data" :key="movement.id">
                <th scope="row">{{ movement.id }}</th>
                <td>{{ movement.user.name }}</td>
                <td>
                    <ul>
                        <li v-for="produto in movement.produtos" :key="produto.id">
                            {{ produto.name }} 
                        </li>
                    </ul>
                </td>
                <td>{{ movement.tipoDePagamento }}</td>
                <td>{{ movement.valor_total }}</td>
                <td>
                    <button type="button" class="btn btn-warning" @click="visuMove(movement)" data-bs-toggle="modal" data-bs-target="#visuMoveModal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                        </svg>
                    </button>
                    <button type="button" class="btn btn-danger" @click="deletemovements(movement.id)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                        </svg>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="totais">
        <button type="button" class="btn btn-warning " data-bs-toggle="modal" data-bs-target="#totaisView">Totais</button>
        <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#exportcsv">CSV</button>
    </div>

    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <li class="page-item" :class="{ disabled: !movements.prev_page_url }">
                <a class="page-link" href="#" @click.prevent="fetchMovements(movements.prev_page_url)">Anterior</a>
            </li>
            <li class="page-item" :class="{ disabled: !movements.next_page_url }">
                <a class="page-link" href="#" @click.prevent="fetchMovements(movements.next_page_url)">Próxima</a>
            </li>
        </ul>
    </nav>




    <VisuMove :movement="selectedMove" />
    <TotaisView :movement="selectedTotais" />
    <exportcsv :movement="selectedcsv" />
    <CreateMoveModal :movement="createMove" />



</template>

<script setup>
import axios from 'axios';
import { ref } from 'vue';
import VisuMove from './modals/visuMove.vue';
import TotaisView from './modals/TotaisView.vue';
import exportcsv from './modals/exportcsv.vue';
import CreateMoveModal from './modals/CreateMoveModal.vue';

const movements = ref({
    data: [],
    prev_page_url: null,
    next_page_url: null
});
const buscartp = ref('');
const selectedMove = ref(null);
const selectedTotais = ref(null);
const createMove = ref(null);


const fetchMovements = (url = 'movements') => {
    axios.get(url).then((response) => {
        movements.value = response.data;
        console.log(movements.value.data)
    }).catch(error => {
        console.log(error);
    });
};



const Pesquisartp = () => {
    if (buscartp.value) {
        axios.get(`movements/search?tipoDePagamento=${buscartp.value}`).then((response) => {
            movements.value = { data: movements.data = response.data };
        }).catch(error => {
            console.log(error);
            alert('Tipo de pagamento não encontrado!');
        });
    } else {
        fetchMovements();
    }
};

const deletemovements = (id) => {
    if (confirm("Tem certeza que deseja deletar essa Movimentação?")) {
        axios.delete(`movements/${id}`).then(() => {
            fetchMovements();
        }).catch(error => {
            console.log(error);
        });
    }
};

const visuMove = (movement) => {
    selectedMove.value = movement;
};

fetchMovements();

</script>

<style scoped>
nav {
    min-width: 700px;
    max-width: 900px;
    margin-left: 300px;
    padding-left: 700px;
}
select{
    max-width: 250px;
}
input {
    min-width: 200px;

}
.buttonform{
    width: 100%;
}
.tabela {
    width: 100%;
    max-width: 900px;
    min-width: 200px;
    margin-left: 300px;
}
button {
    width: 40%;
    margin-left: 5px;
}
.pagination {
    margin-top: 20px;
}
.page-link {
    cursor: pointer;
}
.totais{
    max-width: 500px;
    padding-left: 295px;
}
.btncriaruser{
    margin-left: -700px;
}
</style>
