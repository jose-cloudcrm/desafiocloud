<template>
    <div v-if="produto" class="modal fade" id="editProdutoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Produto: {{produto.id}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="updateproduto">
                        <div class="form-group">
                            <label for="name">Nome</label>
                            <input type="text" class="form-control mb-3" name="name" id="name" required v-model="produto.name">
                        </div>
                        <div class="form-group">
                            <label for="quantidade">Quantidade</label>
                            <input type="number" class="form-control mb-3" name="quantidade" id="quantidade" v-model="produto.quantidade" required>
                        </div>
                        <div class="form-group">
                            <label for="valor">Valor Unitario</label>
                            <input type="number" class="form-control mb-3" name="valor" id="valor" placeholder="R$ 0,00" v-model="produto.valor_unitario" required>
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
    editProduto: Object
});

const produto = ref({ ...props.editProduto });

watch(() => props.editProduto, (newProduto) => {
    produto.value = { ...newProduto };
});


const updateproduto = () => {
    if (produto.value && produto.value.id) {
            axios.put(`produtos/${produto.value.id}`, produto.value).then(response => {
                alert('Produto atualizado com sucesso!');
                window.location.reload();
            }).catch(error => {
                alert('Preencha os campos corretamente');
                console.error('Erro ao atualizar o Produto:', error);
                });
    } else {
        console.error('ID indefinido para o Produto');
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
