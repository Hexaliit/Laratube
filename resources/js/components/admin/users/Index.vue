<template>
    <Base></Base>
    <main class="main">
        <div class="main__sideNav"></div>
        <div class="main__content">
            <section class="users section" id="users">
                <div class="users_container">
                    <div class="titlebar">
                        <div class="titlebar_item">
                            <h1>Users </h1>
                        </div>
                        <div class="titlebar_item">
                            <div class="btn btn__open--modal" @click="openModal">
                                New User
                            </div>
                        </div>
                    </div>

                    <div class="table">

                        <div class="table_filter">
                            <span class="table_filter-Btn ">
                                <i class="fas fa-ellipsis-h"></i>
                            </span>
                            <div>
                                <ul class="table_filter-list">
                                    <li>
                                        <p class="table_filter-link table_filter-link--active">
                                            All
                                        </p>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="table_search">
                            <div class="table_search-wrapper">
                                <select class="table_search-select" name="" id="">
                                    <option value="">Filter</option>
                                </select>
                            </div>
                            <div class="relative">
                                <i class="table_search-input--icon fas fa-search "></i>
                                <input class="table_search--input" type="text" placeholder="Search User">
                            </div>
                        </div>

                        <div class="user_table-heading">
                            <p>Photo</p>
                            <p>Name</p>
                            <p>Role</p>
                            <p>Actions</p>
                        </div>
                        <!-- item 1 -->
                        <div class="user_table-items" v-for="item in users" :key="item.id" v-if="users.length > 0 ">
                            <p>
                                <img :src="ourImage(item.photo)"  class="user_img-list">
                            </p>
                            <p>{{item.name}}</p>
                            <p>{{item.type}}</p>
                            <div>
                                <button class="btn-icon success" @click="editModal(item)">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <button class="btn-icon danger" @click="deleteUser(item.id)">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="modal main__modal " :class="{show : showModal}">
                    <div class="modal__content">
                        <span class="modal__close btn__close--modal" @click="closeModal">×</span>
                        <h3 class="modal__title" v-show="this.editMode === false">Add User</h3>
                        <h3 class="modal__title" v-show="this.editMode === true">Update User</h3>
                        <hr class="modal_line"><br>
                        <form @submit.prevent="this.editMode ? this.updateUser() : this.createUser()">
                        <div>
                            <p>Name</p>
                            <input type="text" class="input"  v-model="this.form.name"/>
                            <small style="color: red" v-if="errors.name">{{this.errors.name}}</small>
                            <p>Email</p>
                            <input type="text" class="input"  v-model="this.form.email"/>
                            <small style="color: red" v-if="errors.email">{{this.errors.email}}</small>
                            <p>Bio</p>
                            <textarea cols="20" rows="3" class="textarea" v-model="this.form.bio"></textarea>

                            <p>Type</p>
                            <select class="inputSelect" name="" id="role" v-model="this.form.type">
                                <option disabled>Select Role</option>
                                <option value="admin">Admin</option>
                                <option value="user">Standard User</option>
                            </select>

                            <p v-show="editMode === false">Password</p>
                            <p v-show="editMode === true">Password (Leave Blank If You Don't Want To Chnage)</p>
                            <input  type="password" id="password" class="input" v-model="this.form.password">
                        </div>
                        <br><hr class="modal_line">
                        <div class="model__footer">
                            <button class="btn mr-2 btn__close--modal" @click="closeModal()">
                                Cancel
                            </button>
                            <button class="btn btn-secondary " v-show="this.editMode === false">Save</button>
                            <button class="btn btn-secondary " v-show="this.editMode === true">Update</button>
                        </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </main>
</template>

<script>
    import Base from "../layouts/Base";
    export default {
        name: "Index",
        components: {Base},
        data : function () {
            return {
                users : [],
                showModal : false,
                hideModal : true,
                errors : {},
                editMode : false,
                form : {
                    name : '',
                    email : '',
                    password : '',
                    bio : '',
                    type : '',
                    photo : '',
                }
            }
        },
        methods : {
            deleteUser : function (id) {
                Swal.fire({
                    title : 'Are You Sure ?',
                    text : "You Can't Go Back !",
                    icon : 'warning',
                    showCancelButton : true,
                    confirmButtonColor : '#3085d6',
                    cancelButtonColor : '#d33',
                    confirmButtonText : 'Yes , Delete it !',
                })
                    .then((result) => {
                        if(result) {
                            axios.get('/api/delete_user/'+id)
                                .then(() => {
                                    Swal.fire(
                                        'Delete',
                                        'User Deleted Successfully',
                                        'success'
                                    )
                                    this.getUsers();
                                })
                        }
                    });
            },
            openModal : function () {
                this.showModal =! this.showModal
                this.form = {}
                this.editMode = false
            },
            updateUser : function(){
                axios.post('/api/update_user/'+this.form.id , this.form)
                    .then(() => {
                        this.getUsers()
                        this.closeModal()
                        toast.fire({
                            icon : "success",
                            title : "User Updated Successfully",
                        })
                    })
            },
            editModal : function(item){
                this.editMode = true
                this.showModal = true
                this.form = item
            },
            closeModal : function () {
                this.showModal =! this.hideModal
            },
            createUser :function(){
                axios.post('/api/create_user', this.form)
                    .then(response => {
                        this.getUsers()
                        this.closeModal()
                        toast.fire({
                            icon : "success",
                            title : "User Created Successfully",
                        })
                    })
                    .catch(error => {
                        if(error.response.status === 422){
                            this.errors = error.response.data.errors
                        }
                    })
            },
            getUsers : function () {
                axios.get('/api/get_all_user')
                    .then(response => {
                        this.users = response.data.users;
                    })
            },
            ourImage : function (img) {
                return `/img/upload/${img}`;
            }
        },
        mounted() {
            this.getUsers()
        },
    }
</script>

<style scoped>

</style>
