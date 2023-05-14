<template>
    <div>
        <section class="vh-100 p-3">
            <div class="container-fluid h-custom">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-xl-6 col-lg-8 col-md-9 wow fadeInUp animated">
                        <div class="login-register-form">
                            <div class="divider d-flex align-items-center my-2">
                                <h3 class="text-center fw-bold mb-0">Добавить товар</h3>
                            </div>
                            <form class="common-form">
                                <div class="form-outline mb-4">
                                    <input v-model="name" type="name" class="form-control form-control-lg"
                                    placeholder="Название" />
                                </div>
                                <div class="form-outline mb-4">
                                    <textarea  v-model="description" class="form-control form-control-lg" 
                                    placeholder ="Описание"></textarea>
                                </div>
                                <div class="form-outline mb-4">
                                    <input v-model="price" type="number" class="form-control form-control-lg"
                                    placeholder="Цена" />
                                </div>

                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Категория
                                    </button>
                                    <ul class="dropdown-menu">
                                        <div v-for = "category in categories">
                                            <li><button @click = "onCategoryChange(category)" class="dropdown-item" type="button">{{category.name}}</button></li>
                                        </div>
                                    </ul>
                                    <p v-if="category_percent">Комиссия составляет {{ category_percent }}% от продажи</p>
                                </div>
                                <br>
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Заглавное изображение</label>
                                    <input @change="onFileChange" class="form-control" type="file" id="formFile" accept="image/png, image/jpeg">
                                </div>
                                <div class="mb-3">
                                    <label for="formFileMultiple" class="form-label">Изображения</label>
                                    <input @change="onFilesChange" class="form-control" type="file" id="formFileMultiple" multiple accept="image/png, image/jpeg">
                                </div>
                                <div>
                                    Характеристики 
                                    <div v-for = "(charField, index) in charFields">
                                        <div class="input-group mb-3">
                                            <input  v-model="charField.char" type="text" class="form-control"
                                                placeholder="Название характеристики" />
                                            <input v-model="charField.value" type="text" class="form-control"
                                                placeholder="Значение характеристики" />
                                            <input @click.prevent="deleteField(index)" type = "button" value = "Удалить" class = "btn btn-primary">
                                        </div>
                                    </div>
                                    <p></p>
                                    <input @click.prevent="addField" type = "button" value = "Добавить поле" class = "btn btn-primary">
                                </div>
                                <p></p>
                                <input @click.prevent="addProduct" type = "submit" value = "Создать" class = "btn btn-primary">
                            </form>
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
    name: 'AddProduct',

    data(){
        return {
            name: null,
            description: null,
            price: null,
            image: null,
            images: null,
            category_id: null,
            category_percent: null,
            categories: [],
            charFields: [{char: '', value:''}]
        }
    },

    created(){
        axios.get('/api/getCategories').then(response =>{
            response.data.forEach(element => {
                this.categories.push(element);
            });
        })
    },

    methods:{
        addProduct(){
            let formProduct = new FormData();
            formProduct.append('name', this.name);
            formProduct.append('description', this.description);
            formProduct.append('price', this.price);
            formProduct.append('category_id', this.category_id);
            formProduct.append('image', this.image);

            let images_count = 0;
            this.images.forEach(image => {
                formProduct.append('images_' + images_count, image); 
                images_count++;    
            });
            formProduct.append('images_count', images_count);

            axios.post('/api/addProduct', formProduct)
                .then(response =>{
                    if (response.data){
                        let formChar = new FormData();
                        let charact_count = 0;
                        this.charFields.forEach(characteristic =>{
                            formChar.append('charact_' + charact_count, characteristic.char);
                            formChar.append('value_' + charact_count, characteristic.value);
                            charact_count++;
                        });
                        formChar.append('charact_count', charact_count);
                        formChar.append('product_id', response.data);
                        axios.post('/api/addCharacteristics', formChar);
                    }
                    this.$router.push({name: 'get.index'});
                })
                .catch(error =>{
                    console.log(error);
                })  
        },

        onFileChange(e) {
            this.image = e.target.files[0];
        },

        onFilesChange(e){
            let images = [];
            let files = e.target.files;
            for (let i = 0; i < files.length; i++){
                images.push(files[i]);
            }
            this.images = images;
        },

        onCategoryChange(category){
            this.category_id = category.id;
            this.category_percent = category.sell_percent;
        },

        addField(){
            this.charFields.push({char: '', value:''});
        },

        deleteField(index){
            if (this.charFields.length > 1){
                this.charFields.splice(index, 1);
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