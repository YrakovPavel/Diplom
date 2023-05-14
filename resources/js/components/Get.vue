<template>
    <div>
        <section>
            <div class="album py-5 bg-body-tertiary">
            <div class="container"> 
                <div class="row">
                    <div class="col-sm-2">
                        <div class="position-absolute start-0">
                            <div v-if="find_flag" class="p-5">
                                <div class="divider d-flex align-items-center my-2">
                                    <h3 class="text-center fw-bold mb-0">Поиск</h3>
                                </div>
                                <div class="form-outline mb-4">
                                    <input v-model="find_name" type="text" class="form-control form-control-lg"
                                    placeholder="Название" />
                                </div>
                                <div class="divider d-flex align-items-center my-2">
                                    <h3 class="text-center fw-bold mb-0">Категория</h3>
                                </div>
                                <ul class="btn-group-vertical">
                                    <div class="form-check form-check-inline mb-0 me-4" v-for = "category in categories">
                                        <input @click="onCategoryChange(category)" class="form-check-input" type="radio" name="inlineRadioOptions" id= "radio-{{category.id}}"/>
                                        <label class="form-check-label" name="inlineRadioOptions" for="radio-{{category.id}}">
                                            <h5 class="mb-0 me-4">{{category.name}}</h5>
                                        </label>
                                    </div>
                                </ul>
                                <br>
                                <div>
                                    <div class="divider d-flex align-items-center my-2">
                                        <h3 class="text-center fw-bold mb-0">Цена:</h3>
                                    </div>
                                    <div class="form-outline mb-4">
                                        <input v-model="price_from" type="number" class="form-control form-control-lg"
                                        placeholder="От" />
                                    </div>
                                    <div class="form-outline mb-4">
                                        <input v-model="price_to" type="number" class="form-control form-control-lg"
                                        placeholder="До" />
                                    </div>
                                    <div class="text-center">
                                        <input @click.prevent="findProducts" type = "submit" value = "Поиск" class = "btn btn-primary m-3">
                                    </div>
                                </div>
                            </div>     
                        </div>
                    </div>  
                    <div class="col-sm-10">
                        <div class="row row-cols-3">
                            <div class="col-sm-6 p-4" style="max-width: 350px; cursor: pointer;" 
                                v-for = "product in products.data" @click = "readProduct(product.id)">
                                <div class="card shadow-sm">
                                    <img :src="product.image_path" class="card-img-top" width="50%" height="225">
                                    <div class="card-body">
                                        <p class="card-text"><b>{{ product.name }}</b></p>
                                        <h4 class="card-text p-1">
                                            <span class="badge bg-secondary">{{ product.price }}₽</span>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center align-items-center">
                            <nav v-if="total > 1" aria-label="Page navigation">
                                <ul class="pagination">
                                    <li class="page-item"><a class="page-link" @click="leftPaginate">Предыдущая</a></li>
                                    <li class="page-item" v-for="numb in total" :key="numb">
                                        <a class="page-link" @click="paginate(numb)">{{numb}}</a>
                                    </li>
                                    <li class="page-item"><a class="page-link" @click="rightPaginate">Следующая</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>

                </div> 
            </div>
        </div>
        </section>
    </div>
</template>

<script>
import axios from 'axios';
import { useRoute } from 'vue-router';

export default{
    name: 'Get',

    data(){
        return {
            products: [],
            categories: [],
            role: null,

            find_flag: false,
            category_id: null,
            price_from: null,
            price_to: null,
            find_name: null,

            page: 1,
            total: null
        }
    },

    mounted(){
        this.getParams();
        this.getProducts();
        this.getCategories();
    },

    methods:{

        getParams(){
            this.token = localStorage.getItem('x-xsrf-token');
            this.role = localStorage.getItem('role');
        },

        getProducts(){
            axios.post(`/api/getProducts?page=${this.page}`, {
                name: this.find_name, 
                category_id: this.category_id,
                price_from: this.price_from,
                price_to: this.price_to})
            .then(response =>{
                if (response.data.data){
                    this.products = response.data;
                    this.total = response.data.last_page;
                    this.find_flag = true;
                }
            })
        },
        
        findProducts(){
            this.page = 1;
            this.getProducts();
        },

        getCategories(){
            axios.get('/api/getCategories').then(response =>{
                response.data.forEach(element => {
                    this.categories.push(element);
                });
            })
        },

        readProduct(id){
            this.$router.push({name: 'user.readProduct', params: {id}});
        },

        onCategoryChange(category){
            this.category_id = category.id;
        },

        rightPaginate(){
            if (this.page < this.total){
                this.page++;
                this.getProducts();
            }
        },

        leftPaginate(){
            if (this.page > 1){
                this.page--;
                this.getProducts();
            }
        },

        paginate(page){
            if (page > this.page){
                this.page++;
                this.getProducts();
            }
            else if(page < this.page){
                this.page--;
                this.getProducts();
            }
        }
    }
}
</script>

<style scoped>
    .divider:after,
    .divider:before {
        content: "";
        flex: 1;
        height: 1px;
        background: #eee;
    }
    .h-custom {
        height: calc(100% - 73px);
    }
    @media (max-width: 450px) {
        .h-custom {
            height: 100%;
        }
    }
</style>