<template>
    <div class="modal fade" id="exportcsv" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Exportar CSV: </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="ms-3 filtro">
                        <select v-model="selectedFilter" class="form-select" @change="updateMonthYear">
                            <option value="all">Todas as Movimentações</option>
                            <option value="last_30_days">Últimos 30 Dias</option>
                            <option value="specific_month">Mês e Ano Específicos</option>
                            </select>
                            <input v-if="selectedFilter === 'specific_month'" type="text" v-model="monthYear" placeholder="MM/YY" class="form-control mt-2"/>
                            <button class="btn btn-info mt-2 btnfiltro" @click="exportMovements">Exportar CSV</button>
                        </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import axios from 'axios';

const props = defineProps({
    selectedcsv: Object
});

const csv = ref({ ...props.selectedcsv });

const selectedFilter = ref('all');
const monthYear = ref('');


const exportMovements = () => {
    let filter = selectedFilter.value;
    let url = `/movement/export-csv?filter=${filter}`;

    if (filter === 'specific_month' && monthYear.value) {
        const [month, year] = monthYear.value.split('/');
        url += `&month=${month}&year=${year}`;
    }

    axios.get(url)
        .then(response => {
            const blob = new Blob([response.data], { type: 'text/csv' });
            const downloadUrl = window.URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = downloadUrl;
            link.setAttribute('download', 'movimentacoes.csv');
            document.body.appendChild(link);
            link.click();
            link.remove();
        })
        .catch(error => {
            console.log(error);
        });
};

</script>

<style scoped>
h3 {
    color: black;
}
h5{
    color: black;
}
label {
    color: black;
}
.modal-body {
    padding: 20px;
}
</style>
