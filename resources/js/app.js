import { createApp } from 'vue';
import Produto from '../components/Produto.vue';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';

const app = createApp({});

app.component('produto', Produto);
app.mount('#app');

