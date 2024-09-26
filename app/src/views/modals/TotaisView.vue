<template>
    <div class="modal fade" id="totaisView" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="exampleModalLabel">Totais</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <h3 class="text-success">Total Débito: <br/>R${{ totaldebits.total_debits }}</h3>
                    <hr />
                    <h3 class="text-danger">Total Crédito: <br/>R${{ totalcredits.total_credits }}</h3>
                    <hr />
                    <h3 class="text-warning">Total: <br/>R${{ totalmetodos.total_movements }}</h3>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';

const props = defineProps({
    selectedTotais: Object
});

const totaldebits = ref('');
const totalcredits = ref('');
const totalmetodos = ref('');

axios.get(`movement/debits`).then((response) => {
    totaldebits.value = response.data;
});
axios.get(`movement/credit`).then((response) => {
    totalcredits.value = response.data;
});
axios.get(`movement/totalmetodos`).then((response) => {
    totalmetodos.value = response.data;
});
</script>

<style scoped>
.modal-body {
    padding: 20px;
}
h3 {
    color: black;
}
.modal-header {
    padding: 15px;
}
</style>
