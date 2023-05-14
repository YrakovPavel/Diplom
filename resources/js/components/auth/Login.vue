<template>
    <div>
        <div class="modal" tabindex="-1" :style="{'display': display_flag}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Пользователь заблокирован</h5>
                        <button @click="display_flag = 'none'" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Ваша учетная запись заблокирована за нарушение правил</p>
                    </div>
                </div>
            </div>
        </div>
        <section class="vh-100">
            <div class="container-fluid h-custom">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-md-9 col-lg-6 col-xl-5">
                        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
                        class="img-fluid" alt="Sample image">
                    </div>
                    <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                        <form>
                            <div class="divider d-flex align-items-center my-4">
                                <h3 class="text-center fw-bold mb-0">Авторизация</h3>
                               <!--<p class=" mx-3 mb-0"></p>--> 
                            </div>

                            <!-- Email input -->
                            <div class="form-outline mb-4">
                                <input v-model="email" type="email" class="form-control form-control-lg"
                                placeholder="Введите почтовый адрес" />
                            </div>

                            <!-- Password input -->
                            <div class="form-outline mb-3">
                                <input v-model="password" type="password" class="form-control form-control-lg"
                                placeholder="Введите пароль" />
                            </div>

                            <div class="text-center text-lg-start mt-4 pt-2">
                                <button @click="login"  type="button" class="btn btn-primary btn-lg"
                                style="padding-left: 2.5rem; padding-right: 2.5rem;">Войти</button>
                                <p class="small fw-bold mt-2 pt-1 mb-0">У вас нет аккаунта? 
                                    <a @click="registration" class="link-danger">Зарегистрироваться</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import axios from 'axios';

export default{
    name: 'Login',

    data(){
        return {
            email: null,
            password: null,

            display_flag: 'none'
        }
    },

    methods:{
        login(){
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post('/ifBanned', {email: this.email}).then(response =>{
                    if (!response.data){
                        axios.post('/login', {email: this.email, password: this.password})
                        .then(response =>{
                            axios.get('/api/getRole').then(response =>{
                                localStorage.setItem('role', response.data.role);
                                localStorage.setItem('id', response.data.id);
                            });
                            localStorage.setItem('x-xsrf-token', response.config.headers['X-XSRF-TOKEN']);
                            this.$router.push({name: 'get.index'});
                        })
                        .catch(error =>{
                            console.log(error);
                        })
                    }
                    else{
                        this.display_flag = 'block';
                    }
                })
            });
        },

        registration(){
            this.$router.push({name: 'user.registration'});
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