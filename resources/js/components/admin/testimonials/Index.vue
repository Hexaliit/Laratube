<template>
    <Base></Base>
    <main class="main">
        <div class="main__sideNav"></div>
        <div class="main__content">
            <section class="testimonials section" id="testimonials">
                <div class="testimonials_container">
                    <div class="titlebar">
                        <div class="titlebar_item">
                            <h1>Testimonials </h1>
                        </div>
                        <div class="titlebar_item">
                            <div class="btn " @click="newTestimonial">
                                New Testimonial
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
                                <input class="table_search--input" type="text" placeholder="Search Testimonial">
                            </div>
                        </div>

                        <div class="testimonial_table-heading">
                            <p>Photo</p>
                            <p>name</p>
                            <p>Function</p>
                            <p>Testimony</p>
                            <p>Rating</p>
                            <p>Actions</p>
                        </div>
                        <!-- item 1 -->
                        <div class="testimonial_table-items" v-if="testimonials.length > 0" v-for="item in testimonials" :key="item.id">
                            <p>
                                <img :src="ourImage(item.photo)" class="testimonial_img-list">
                            </p>
                            <p>{{item.name}}</p>
                            <p>{{item.function}}</p>
                            <p>{{item.testimony}}</p>
                            <p>{{item.rating}} / 5</p>
                            <div>
                                <button class="btn-icon success" @click="onEdit(item.id)">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <button class="btn-icon danger" @click="deleteTestimonial(item.id)">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>

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
        components : {
            Base
        } ,
        data : function() {
            return {
                testimonials : [],
            }
        },
        methods : {
            getTestimonials : function () {
                axios.get('/api/get_all_testimonial')
                    .then(response => {
                        this.testimonials = response.data.testimonials;
                    })
            },
            deleteTestimonial : function(id) {
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
                            axios.get('/api/delete_testimonial/'+id)
                                .then(() => {
                                    Swal.fire(
                                        'Delete',
                                        'Skill Deleted Successfully',
                                        'success'
                                    )
                                    this.getTestimonials();
                                })
                        }
                    });
            },
            newTestimonial : function () {
                this.$router.push('/admin/testimonials/new');
            },
            ourImage : function (img) {
                return "/img/upload/"+img;
            },
            onEdit : function(id){
              this.$router.push('/admin/testimonials/edit/'+id);
            },
        } ,
        mounted() {
            this.getTestimonials();
        },
    }
</script>

<style scoped>

</style>
