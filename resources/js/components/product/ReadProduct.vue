<template>
    <div>
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
        
        <!-- The Modal -->
        <div id="myModal" class="modal" :style="{'display': display_flag}">
            <span @click="display_flag='none'" class="close">&times;</span>
            <img width="680" height="450" class="modal-content" :src="show_image" id="img01">
        </div>

        <div class="container">
            <div class="card">
                <div class="container-fliud">
                    <div class="wrapper row">
                        <div class="preview col-md-6">
                            
                            <div class="preview-pic tab-content">
                                <div class="tab-pane active" id="pic-x">
                                    <img @click="showImage(this.product.image)" :src = "this.product.image" width = "400" height = "400">
                                </div>
                                <div v-for="(image, index) in product.images" class="tab-pane" :id="'pic-' + index">
                                    <img :src= "image" />
                                </div>
                            </div>
                            <ul class="preview-thumbnail nav nav-tabs">
                                <li v-for="(image, index) in product.images">
                                    <a :data-target="'#pic-2' + index">
                                        <img @click="showImage(image)" :src= "image" width="100" height="75"/>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="details col-md-6">
                            <h3 class="product-title">{{ this.product.name }}</h3>
                            <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <b>Продавец: </b>
                                    <a href="#" @click="this.$router.push({name: 'user.personal', params: {'id': product.seller_id}});">
                                        {{seller.name}}
                                    </a>
                                </li>
                            </ol>
                            </nav>
                            <div class="rating">
                                <h5><b>Рейтинг продавца: </b></h5>
                                <div class="stars">
                                    <span v-for="index in seller.grade" class="fa fa-star checked"></span>
                                    <span v-for="index in seller.restGrade" class="fa fa-star"></span>
                                </div>
                            </div>
                            <div>
                                <h5><b>Характеристики: </b></h5>
                                <p v-for="characteristic in this.product.characteristics">
                                    <b>{{characteristic.name}}: </b> {{ characteristic.value }}
                                </p>
                            </div>
                            <h5><b>Описание:</b></h5>
                            <p class="product-description">{{ this.product.description }}</p>
                            <h4 class="price">Цена: <span>{{ product.price }}₽</span></h4>
                            <div v-if="user_id != product.seller_id" class = "py-3">
                                <button @click = "buyProduct" class="btn btn-primary" type="button">Купить</button>
                            </div>
                            <div class="p-2">
                                <button v-if ="user_id == product.seller_id" type="button"
                                    @click = "editProduct(product_id)" class="btn btn-primary" >Редактирование</button>
                            </div>
                            <div class="p-2">
                                <button v-if ="roleConditions(product.seller_id)" type="button" 
                                    @click = "deleteProduct(product_id)" class="btn btn-primary" >Удаление</button>
                            </div>
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
    name: 'ReadProduct',

    data(){
        return {
            product: {
                name: null,
                description: null,
                price: null,
                seller_id: null,
                image: null,
                images: null,
                characteristics: null,
            },

            seller:{
                name: null,
                grade: null,
                restGrade: null
            },

            product_id: this.$route.params.id,
            user_id: localStorage.getItem('id'),
            role: localStorage.getItem('role'),

            display_flag: 'none',
            show_image: null
        }
    },

    created(){
        this.readProduct();
    },

    methods:{
        readProduct(){
            axios.post('/api/readProduct', {id: this.product_id}).then(response =>{
                this.product = response.data;
                axios.post('/api/getUser', {id: this.product.seller_id}).then(response =>{
                    this.seller = response.data;
                    this.seller.restGrade = 5 - this.seller.grade;
                })
            })
        },

        buyProduct(){
            axios.post('/api/buyProduct', {id: this.product_id}).then(response =>{
                if (response.data){
                    this.$router.push({name: 'get.index'});
                }
            })
        },

        editProduct(id){
            this.$router.push({name: 'user.editProduct', params: {id}});
        },

        deleteProduct(id){
            axios.post('/api/deleteProduct', {id});
            this.$router.push({name: 'get.index'});
        },

        roleConditions(seller_id){
           if ((this.role == 'admin') || (this.id == seller_id)){
                return true
           }
        },

        showImage(image){
            this.display_flag ='block';
            this.show_image = image;
        }
    }
}
</script>

<style scoped>
body {
  font-family: 'open sans';
  overflow-x: hidden; }

img {
  max-width: 100%; }

.preview {
  display: -webkit-box;
  display: -webkit-flex;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
  -webkit-flex-direction: column;
      -ms-flex-direction: column;
          flex-direction: column; }
  @media screen and (max-width: 996px) {
    .preview {
      margin-bottom: 20px; } }

.preview-pic {
  -webkit-box-flex: 1;
  -webkit-flex-grow: 1;
      -ms-flex-positive: 1;
          flex-grow: 1; }

.preview-thumbnail.nav-tabs {
  border: none;
  margin-top: 15px; }
  .preview-thumbnail.nav-tabs li {
    width: 18%;
    margin-right: 2.5%; }
    .preview-thumbnail.nav-tabs li img {
      max-width: 100%;
      display: block; }
    .preview-thumbnail.nav-tabs li a {
      padding: 0;
      margin: 0; }
    .preview-thumbnail.nav-tabs li:last-of-type {
      margin-right: 0; }

.tab-content {
  overflow: hidden; }
  .tab-content img {
    width: 100%;
    -webkit-animation-name: opacity;
            animation-name: opacity;
    -webkit-animation-duration: .3s;
            animation-duration: .3s; }

.card {
  margin-top: 50px;
  background: #eee;
  padding: 3em;
  line-height: 1.5em; }

@media screen and (min-width: 997px) {
  .wrapper {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex; }
    .modal-content {
    width: 100%;} }



.details {
  display: -webkit-box;
  display: -webkit-flex;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
  -webkit-flex-direction: column;
      -ms-flex-direction: column;
          flex-direction: column; }

.colors {
  -webkit-box-flex: 1;
  -webkit-flex-grow: 1;
      -ms-flex-positive: 1;
          flex-grow: 1; }

.product-title, .price, .sizes, .colors {
  text-transform: UPPERCASE;
  font-weight: bold; }

.checked, .price span {
  color: #ff9f1a; }

.product-title, .rating, .product-description, .price, .vote, .sizes {
  margin-bottom: 15px; }

.product-title {
  margin-top: 0; }

.size {
  margin-right: 10px; }
  .size:first-of-type {
    margin-left: 40px; }

.color {
  display: inline-block;
  vertical-align: middle;
  margin-right: 10px;
  height: 2em;
  width: 2em;
  border-radius: 2px; }
  .color:first-of-type {
    margin-left: 20px; }

.add-to-cart, .like {
  background: #ff9f1a;
  padding: 1.2em 1.5em;
  border: none;
  text-transform: UPPERCASE;
  font-weight: bold;
  color: #fff;
  -webkit-transition: background .3s ease;
          transition: background .3s ease; }
  .add-to-cart:hover, .like:hover {
    background: #b36800;
    color: #fff; }

.not-available {
  text-align: center;
  line-height: 2em; }
  .not-available:before {
    font-family: fontawesome;
    content: "\f00d";
    color: #fff; }

.orange {
  background: #ff9f1a; }

.green {
  background: #85ad00; }

.blue {
  background: #0076ad; }

.tooltip-inner {
  padding: 1.3em; }

@-webkit-keyframes opacity {
  0% {
    opacity: 0;
    -webkit-transform: scale(3);
            transform: scale(3); }
  100% {
    opacity: 1;
    -webkit-transform: scale(1);
            transform: scale(1); } }

@keyframes opacity {
  0% {
    opacity: 0;
    -webkit-transform: scale(3);
            transform: scale(3); }
  100% {
    opacity: 1;
    -webkit-transform: scale(1);
            transform: scale(1); } }

/* Style the Image Used to Trigger the Modal */
#myImg {
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}

#myImg:hover {opacity: 0.7;}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (Image) */
.modal-content {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
}

/* Caption of Modal Image (Image Text) - Same Width as the Image */
#caption {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
  text-align: center;
  color: #ccc;
  padding: 10px 0;
  height: 150px;
}

/* Add Animation - Zoom in the Modal */
.modal-content, #caption {
  animation-name: zoom;
  animation-duration: 0.6s;
}

@keyframes zoom {
  from {transform:scale(0)}
  to {transform:scale(1)}
}

/* The Close Button */
.close {
  position: absolute;
  top: 15px;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.close:hover,
.close:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}

</style>