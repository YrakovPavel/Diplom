<template>
    <div>
        <!--Start Login Page-->
        <section class="vh-100">
            <div class="container-fluid h-custom">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-xl-6 col-lg-8 col-md-9 wow fadeInUp animated">
                        <div class="login-register-form">
                            <div class="divider d-flex align-items-center my-2">
                                <h3 class="text-center fw-bold mb-0">Регистрация</h3>
                            </div>
                            
                            <form class="common-form">
                                <div class="form-outline mb-4">
                                    <input v-model="name" type="name" class="form-control form-control-lg"
                                    placeholder="Введите имя" />
                                </div>

                                <div class="form-outline mb-4">
                                    <input v-model="email" type="email" class="form-control form-control-lg"
                                    placeholder="Введите почтовый адрес" />
                                </div>

                                <div class="form-outline mb-4">
                                    <input v-model="password" type="password" class="form-control form-control-lg"
                                    placeholder="Введите пароль" />
                                </div>

                                <div class="form-outline mb-4">
                                    <input v-model="password_confirmation" type="password" class="form-control form-control-lg"
                                    placeholder="Подтвердите пароль" />
                                </div>

                                <div class="form-outline mb-4"> 
                                    <input v-model="date_of_birth" type ='date' class="form-control form-control-lg" data-provide="datepicker">
                                </div>
                            </form>
                            <div class="text-center">
                                <button @click="register"  type="button" class="btn btn-primary btn-lg"
                                style="padding-left: 2.5rem; padding-right: 2.5rem;">Зарегистрироваться</button>
                                <p class="small fw-bold mt-2 pt-1 mb-0">Уже зарегистрированы? 
                                    <a @click="login" class="link-danger">Войти</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--End Login Page-->
    </div>
</template>

<script>
import axios from 'axios';

export default{
    name: 'Registration',

    data(){
        return {
            name: null,
            email: null,
            password: null,
            password_confirmation: null,
            date_of_birth: null
        }
    },

    methods:{
        register(){
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post('/register', {
                    name: this.name,
                    email: this.email,
                    password: this.password, 
                    password_confirmation: this.password_confirmation,
                    date_of_birth: this.date_of_birth
                })
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
            })
        },

        login(){
            this.$router.push({name: 'user.login'});
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