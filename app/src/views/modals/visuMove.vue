<template>
    <div v-if="movement" class="modal fade modalp" id="visuMoveModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Visualização da Movimentação</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h2 class="user">Usuário:</h2>
                    <table class="table table-striped table-primary tabela">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Email</th>
                                <th scope="col">Data de Nascimento</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">{{ movement.user.id }}</th>
                                <td>{{ movement.user.name }}</td>
                                <td>{{ movement.user.email }}</td>
                                <td>{{ movement.user.birthday }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <h2>Produto:</h2>
                    <table class="table table-striped table-light tabela">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Quantidade</th>
                                <th scope="col">Valor Unitario</th>
                                <th scope="col"> Valor Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="produto in movement.produtos" :key="produto.id">
                                <th scope="row">{{ produto.id }}</th>
                                <td>{{ produto.name }}</td>
                                <td>{{ produto.quantidade }}</td>
                                <td>{{ produto.valor_unitario }}</td>
                                <td>{{ produto.valor_total }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps } from 'vue';

const props = defineProps({
    movement: Object
});
</script>

<style scoped>
h2 {
    color: black;
}
h5 {
    color: black;
}
label {
    color: black;
}
.modal-dialog {
    max-width: 50%;
}
.modal-body {
    padding: 30px;
}
.table {
    width: 100%;
}
td, th {
    min-width: 50px;
}
.user {
    padding-bottom: 20px;
}
</style>
