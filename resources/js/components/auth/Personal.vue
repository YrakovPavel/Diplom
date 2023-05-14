<template>
    <div>
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
        <section>
            <div class="container my-3 py-3">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-12 col-lg-10">
                        <div class="card text-dark">
                            <div class="card-body p-4">
                                <h3 class="mb-0"><b>Информация о пользователе</b></h3>
                                <br>
                                <h5><b>Пользователь</b></h5>
                                <p class="mb-0">{{ user.name }}</p> 
                                <br>
                                <h5><b>Почта</b></h5>
                                <p class="mb-0">{{ user.email }}</p> 
                                <br>
                                <h5><b>Дата рождения</b></h5>
                                <p class="mb-0">{{ user.date_of_birth}}</p> 
                                <br>
                                <div class="rating">
                                <h5><b>Рейтинг продавца: </b></h5>
                                <div class="stars">
                                    <span v-for="index in user.grade" class="fa fa-star checked"></span>
                                    <span v-for="index in user.restGrade" class="fa fa-star"></span>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="container my-3 py-3">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-12 col-lg-10">
                        <div class="card text-dark">
                            <div class="card-body p-4">
                                <h4 class="mb-0"><b>Отзывы на товары</b></h4>
                            </div>

                            <div v-for="(review, index) in reviews.data">
                                <hr class="my-0" />
                                <div class="card-body p-4">
                                    <div class="d-flex flex-start">
                                        <div>
                                            <h6 class="fw-bold mb-1">Отзыв пользователя {{review.name}} на "{{ review.product_name }}":</h6>
                                            <p class="mb-0">{{review.comment}}</p>
                                            <div class="d-flex align-items-center mb-3">
                                                <p class="mb-0">
                                                    <b>Итоговая оценка: </b>{{ review.grade }}
                                                </p>
                                            </div>
                                            <button v-if="role == 'admin'" @click="deleteReview(review.id, index)"  type="button" class="btn btn-primary">
                                                Удалить
                                            </button>
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


export default{
    name: 'Personal',

    data(){
        return {
            id: this.$route.params.id,
            user: {
                name: null,
                email: null,
                date_of_birth: null,
                grade: null,
                restGrade: null
            },
            reviews: [],

            role: localStorage.getItem('role'),

            page: 1,
            total: null
        }
    },

    mounted(){
        axios.post('/api/getUser', {id: this.id}).then(response =>{
            this.user = response.data;
            this.user.restGrade = 5 - this.user.grade;
        })
        this.getReviews();
    },

    methods:{
        getReviews(){
            axios.post(`/api/getReviews?page=${this.page}`, {id: this.id}).then(response =>{
                this.reviews = response.data;
                this.total = response.data.last_page;
            })
        },

        rightPaginate(){
            if (this.page < this.total){
                this.page++;
                this.getReviews();
            }
        },

        leftPaginate(){
            if (this.page > 1){
                this.page--;
                this.getReviews();
            }
        },

        paginate(page){
            if (page > this.page){
                this.page++;
                this.getReviews();
            }
            else if(page < this.page){
                this.page--;
                this.getReviews();
            }
        },

        deleteReview(id, index){
            axios.post('/api/deleteReview', {id}).then(response=>{
                if (response.data){
                    this.reviews.data.splice(index, 1);
                }
            });
        }
    }

}
</script>

<style scoped>

.checked, .price span {
  color: #ff9f1a; }

</style>