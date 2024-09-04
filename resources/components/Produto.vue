<template>
    <div class="container mt-4">
        <!-- Alertas -->
        <div v-if="alert" :class="['alert', `alert-${alert.type}`]" role="alert">
            {{ alert.message }}
        </div>

        <!-- Botão para abrir o modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#produtoModal">
            {{ editando ? 'Editar Produto' : 'Adicionar Produto' }}
        </button>

        <!-- Modal para o formulário -->
        <div class="modal fade" id="produtoModal" tabindex="-1" aria-labelledby="produtoModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="produtoModalLabel">{{ editando ? 'Editar Produto' : 'Adicionar Produto' }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="adicionarOuEditarProduto" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome</label>
                                <input id="nome" v-model="produto.nome" class="form-control" placeholder="Nome" required>
                            </div>

                            <div class="mb-3">
                                <label for="descricao" class="form-label">Descrição</label>
                                <input id="descricao" v-model="produto.descricao" class="form-control" placeholder="Descrição">
                            </div>

                            <div class="mb-3">
                                <label for="preco" class="form-label">Preço</label>
                                <input id="preco" v-model="produto.preco" class="form-control" placeholder="Preço" required type="number" step="0.01">
                            </div>

                            <div class="mb-3">
                                <label for="data_validade" class="form-label">Data de Validade</label>
                                <input id="data_validade" v-model="produto.data_validade" class="form-control" type="date" required>
                            </div>

                            <div class="mb-3">
                                <label for="imagem" class="form-label">Imagem</label>
                                <input id="imagem" type="file" class="form-control" @change="handleFileUpload">
                            </div>

                            <div class="mb-3">
                                <label for="categoria" class="form-label">Categoria</label>
                                <select id="categoria" v-model="produto.categoria_id" class="form-select" required>
                                    <option v-for="categoria in categorias" :value="categoria.id" :key="categoria.id">
                                        {{ categoria.nome }}
                                    </option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">{{ editando ? 'Atualizar' : 'Adicionar' }} Produto</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabela de produtos -->
        <table class="table table-striped mt-4">
            <thead>
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Preço</th>
                    <th scope="col">Data de Validade</th>
                    <th scope="col">Categoria</th>
                    <th scope="col">Imagem</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="produto in produtos" :key="produto.id">
                    <td>{{ produto.nome }}</td>
                    <td>{{ produto.descricao }}</td>
                    <td>{{ produto.preco }}</td>
                    <td>{{ produto.data_validade }}</td>
                    <td>{{ produto.categoria ? produto.categoria.nome : 'N/A' }}</td>
                    <td>
                        <img v-if="produto.imagem" :src="'/api/imagem/' + produto.imagem" alt="Imagem do produto" class="img-thumbnail" style="max-width: 100px;">
                    </td>
                    <td>
                        <button @click="carregarProdutoParaEdicao(produto)" class="btn btn-warning btn-sm me-2" data-bs-toggle="modal" data-bs-target="#produtoModal">Editar</button>
                        <button @click="excluirProduto(produto.id)" class="btn btn-danger btn-sm">Excluir</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            produtos: [],
            categorias: [],
            produto: {
                id: null,
                nome: '',
                descricao: '',
                preco: '',
                data_validade: '',
                categoria_id: null,
                imagem: null
            },
            editando: false,
            file: null,
            alert: null // Adicione a propriedade para alertas
        };
    },
    methods: {
        carregarCategorias() {
            axios.get('/api/categorias')
                .then(response => {
                    this.categorias = response.data;
                })
                .catch(error => {
                    this.showAlert('danger', 'Erro ao carregar categorias.');
                    console.error('Erro ao carregar categorias:', error);
                });
        },
        carregarProdutos() {
            axios.get('/api/produtos')
                .then(response => {
                    this.produtos = response.data;
                })
                .catch(error => {
                    this.showAlert('danger', 'Erro ao carregar produtos.');
                    console.error('Erro ao carregar produtos:', error);
                });
        },
        handleFileUpload(event) {
            this.file = event.target.files[0];
        },
        adicionarOuEditarProduto() {
            let formData = new FormData();
            formData.append('nome', this.produto.nome);
            formData.append('descricao', this.produto.descricao);
            formData.append('preco', this.produto.preco);
            formData.append('data_validade', this.produto.data_validade);
            formData.append('categoria_id', this.produto.categoria_id);
            if (this.file) {
                formData.append('imagem', this.file);
            }

            let request;
            if (this.editando) {
                request = axios.put(`/api/produtos/${this.produto.id}`, formData);
            } else {
                request = axios.post('/api/produtos', formData);
            }

            request.then(() => {
                this.showAlert('success', 'Produto salvo com sucesso.');
                this.carregarProdutos();
                this.resetarFormulario();
            }).catch(error => {
                this.showAlert('danger', 'Erro ao salvar produto.');
                console.error('Erro ao salvar produto:', error);
            });
        },
        carregarProdutoParaEdicao(produto) {
            this.produto = { ...produto };
            this.editando = true;
        },
        excluirProduto(id) {
            axios.delete(`/api/produtos/${id}`)
                .then(() => {
                    this.showAlert('success', 'Produto excluído com sucesso.');
                    this.carregarProdutos();
                })
                .catch(error => {
                    this.showAlert('danger', 'Erro ao excluir produto.');
                    console.error('Erro ao excluir produto:', error);
                });
        },
        resetarFormulario() {
            this.produto = { id: null, nome: '', descricao: '', preco: '', data_validade: '', categoria_id: null };
            this.file = null;
            this.editando = false;
        },
        showAlert(type, message) {
            this.alert = { type, message };
            setTimeout(() => {
                this.alert = null;
            }, 5000); // O alerta desaparecerá após 5 segundos
        }
    },
    mounted() {
        this.carregarProdutos();
        this.carregarCategorias();
    }
};
</script>
