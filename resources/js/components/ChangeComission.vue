<template>
    <section class="vh-100">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-xl-6 col-lg-8 col-md-9 wow fadeInUp animated">
                    <div class="card text-dark">
                        <div class="p-3">
                            <h3 class="text-center fw-bold mb-0 p-2">Комиссия</h3>
                            <div class="input-group mb-3 text-center" v-for="category in this.categories">
                                <div class="form-floating">
                                    <span for="floatingInputGroup1" class="text-center">{{category.name}}</span>
                                    <br>
                                    <input v-model="category.sell_percent" type="range" min = "0" max = "50" id="floatingInputGroup1">
                                    {{ category.sell_percent }}% от продажи
                                </div>
                            </div>
                            <div class="col-md-12 text-center p-2">
                                <input @click.prevent="changeComission" type = "submit" value = "Изменить комиссию" class = "btn btn-primary">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import axios from 'axios';
import { useRoute } from 'vue-router';

export default{
    name: 'ChangeComission',
    
    data(){
        return {
            categories: [{name: null, sell_percent: null}]
        }
    },

    created(){
        axios.get('/api/getCategories').then(response =>{
            this.categories = [];
            response.data.forEach(element => {
                this.categories.push(element);
            });
        })
    },

    methods:{
        changeComission(){
            axios.post('/api/changeComission', this.categories).then(response=>{
                this.$router.push({name: 'get.index'});
            })
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