<template>

    <div>
        <!-- Modal -->
        <div class="modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><b>Заблокировать пользователя</b></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input v-model="userToBan" type = "text" placeholder="Почта пользователя" class = "form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                        <button type="button" @click="banUser" data-bs-dismiss="modal" class="btn btn-primary">Заблокировать</button>
                    </div>
                </div>
            </div>
        </div>

        <nav v-if="token" class="navbar navbar-expand-md navbar-dark bg-primary">
            <h2 class="navbar-brand text-center fw-bold mb-0 p-2">Интернет-магазин</h2>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active p-1">
                    <a class="nav-link mb-0 h6 fw-bold" style="cursor: pointer;" @click.prevent="onGet">Главная <span class="sr-only"></span></a>
                </li>
                <li class="nav-item active p-1">
                    <a class="nav-link mb-0 h6 fw-bold" style="cursor: pointer;" @click.prevent="onPersonal">Профиль <span class="sr-only"></span></a>
                </li>
                <li class="nav-item active p-1">
                    <a class="nav-link mb-0 h6 fw-bold" style="cursor: pointer;" 
                        @click.prevent="onAddProduct">Добавить товар 
                        <span class="sr-only"></span>
                    </a>
                </li>
                <li class="nav-item active p-1">
                    <a class="nav-link mb-0 h6 fw-bold" style="cursor: pointer;" @click.prevent="onCheckProduct">Просмотр товаров <span class="sr-only"></span></a>
                </li>
                <li v-if="role == 'admin'" class="nav-item active p-1">
                    <a class="nav-link mb-0 h6 fw-bold" style="cursor: pointer;" @click.prevent="oneChangeComission">Изменить комиссию <span class="sr-only"></span></a>
                </li>
                <li v-if="role == 'admin'" class="nav-item active p-1">
                    <a class="nav-link mb-0 h6 fw-bold" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#exampleModal">Заблокировать пользователя</a>
                </li>
                <li class="nav-item active p-1">
                    <a class="nav-link mb-0 h6 fw-bold" style="cursor: pointer;" @click.prevent="logout">Выход <span class="sr-only"></span></a>
                </li>
            </ul> 
        </nav>
        <router-view :key="$route.fullPath"></router-view>
    </div>
</template>

<script>
import axios from 'axios';


export default{
    name: 'Index',

    data(){
        return{
            token: null,
            role: null,
            userToBan: null
        }
    },

    updated(){
        this.getParams();
    },

    created(){
        this.getParams();
    },

    methods:{
        getParams(){
            this.token = localStorage.getItem('x-xsrf-token');
            this.role = localStorage.getItem('role');
        },

        onGet(){
            this.$router.push({name: 'get.index'});
        },

        onPersonal(){
            let id = localStorage.getItem('id');
            this.$router.push({name: 'user.personal', params: {id}});
        },

        onAddProduct(){
            this.$router.push({name: 'user.addProduct'});
        },

        onCheckProduct(){
            this.$router.push({name: 'user.checkProduct'});
        },

        oneChangeComission(){
            this.$router.push({name: 'changeComission'});
        },

        logout(){
            axios.post('/logout')
            .then(response=>{
                localStorage.removeItem('x-xsrf-token');
                localStorage.removeItem('role');
                localStorage.removeItem('id');
                this.$router.push({name: 'user.login'});
            })
        },

        banUser(){
            axios.post('/api/banUser', {email: this.userToBan});
        }
    }
}
</script>

<style scoped>

</style>