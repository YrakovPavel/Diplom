<template>
    <div>
        <div>
            <!-- Modal -->
            <div class="modal" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="reviewModalLabel">Отзыв на товар "{{ target_name }}":</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                    <div class="modal-body">
                        <textarea v-model="target_description[target_id]" class="form-control" placeholder ="Description"></textarea>
                        <div class="dropdown p-3">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        Оценка
                                    </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li v-for="grade in grade_numbers"><button @click="onGradeChange(grade)" class="dropdown-item">{{grade}}</button></li>
                            </ul>
                            <p v-if="target_grade">Выбранная оценка: {{ target_grade }}</p>
                        </div>
                    </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                            <button type="button" @click="sendReview" data-bs-dismiss="modal" class="btn btn-primary">Отправить</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container centered p-5">
            <div class="row d-flex justify-content-center align-items-center p-2">
                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                    <input @click="checkBought" type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked>
                    <label class="btn btn-outline-primary" for="btnradio1">Купленные товары</label>

                    <input @click="checkSeller" type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
                    <label class="btn btn-outline-primary" for="btnradio2">Товары, выставленные на продажу</label>
                </div>
            </div>
            <br>
            <div class="card mb-3" v-for="(product, index) in products" style="height: 200px;">
                <div class="row g-0">
                    <div class="col-md-2">
                        <img :src="product.image_path" class="img-fluid rounded-start" style="height: 200px; width: 200px;">
                    </div>
                    <div class="col-md-10">
                        <div class="card-body">
                            <h5 class="card-title">{{ product.name }}</h5>
                            {{ product.description }}
                            <p>
                                Цена: {{ product.price }}
                            </p>
                            <input v-if="product_flag" @click = "showModal(product.name, product.id, index)" data-bs-toggle="modal" data-bs-target="#reviewModal" type = "submit" value = "Отправить отзыв" class = "btn btn-primary">

                            <button v-if="!product_flag" type="button" @click = "readProduct(product.id)" class="btn btn-sm btn-outline-secondary">Просмотр</button>
                            <button v-if="!product_flag" type="button" @click = "editProduct(product.id)" class="btn btn-sm btn-outline-secondary">Редактирование</button>
                            <button v-if="!product_flag" type="button" @click = "deleteProduct(product.id, index)" class="btn btn-sm btn-outline-secondary">Удаление</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default{
    name: 'CheckProduct',

    data(){
        return {
            boughtProducts: [],
            sellerProducts: [],
            products: [],
            product_flag: true,

            grade_numbers: [ 1, 2, 3, 4, 5 ],
            target_index: null,
            target_id: null,
            target_name: null,
            target_grade: 0,
            target_description: []
        }
    },

    created(){
        this.getProducts();
    }, 

    methods:{
        getProducts(){
            axios.get('/api/getBoughtProducts').then(response =>{
                this.boughtProducts = response.data;
                this.products = response.data;
            })
            axios.get('/api/getSellerProducts').then(response =>{
                this.sellerProducts = response.data;
            })
        },

        checkBought(){
            this.products = this.boughtProducts;
            this.product_flag = true;
        },

        checkSeller(){
            this.products = this.sellerProducts;
            this.product_flag = false;
        },

        readProduct(id){
            this.$router.push({name: 'user.readProduct', params: {id}});
        },

        editProduct(id){
            this.$router.push({name: 'user.editProduct', params: {id}});
        },

        deleteProduct(id, index){
            axios.post('/api/deleteProduct', {id}).then(response=>{
                if (response.data){
                    this.products.splice(index, 1);
                }
            });
        },

        showModal(name, id, index){
            this.target_index = index;
            this.target_name = name;
            this.target_id = id;
        },

        sendReview(){
            axios.post('/api/addReview', {
                product_id: this.target_id,
                comment: this.target_description[this.target_id],
                grade: this.target_grade
            }).then(response =>{
                if (response.data){
                    this.products.splice(this.target_index, 1);
                }
            })
        },

        onGradeChange(grade){
            this.target_grade = grade;
        }
    }
}
</script>

<style scoped>
</style>