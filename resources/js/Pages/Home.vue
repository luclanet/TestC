<template>
    <div class="home">
        <div v-if="$store.getters.isLoggedIn">
            Welcome {{$store.getters.user.name}}

            <div class="alert alert-danger" role="alert" v-if="error">
                {{error}}
            </div>

            <table class="table" v-if="movies">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Genre(s)</th>
                    <th scope="col">Release Date</th>
                    <th scope="col">Details</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="movie in movies.data">
                    <th scope="row">{{movie["id"]}}</th>
                    <td>{{movie["name"]}}</td>
                    <td v-html="movie.genre.split(',').join('<br>')"></td>
                    <td>{{formatDate(movie.release_date)}}</td>
                    <td v-html="movie.details" class="renderLink"></td>
                </tr>
                </tbody>
            </table>
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item" v-for="page in pages(1, movies.last_page)"><router-link class="page-link" :to="'?page='+page">
                        <template v-if="page != current_page">{{page}}</template>
                        <b v-if="page == current_page">{{page}}</b>
                    </router-link></li>
                </ul>
            </nav>
        </div>
        <div class="modal show" tabindex="-1" role="dialog" v-if="modelOpen"
             style="padding-right: 16px; display: block;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLiveLabel">Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                @click="modelOpen = false">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="progress" v-if="!movie">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%"></div>
                        </div>
                        <div v-if="movie">
                            <div class="row">
                                <div class="col-4" v-if="movie.poster_path">
                                    <img :src="'https://image.tmdb.org/t/p/w500' + movie.poster_path" :alt="movie.title">
                                </div>
                                <div :class="(movie.poster_path ? 'col-8' : 'col-12')">
                                    <h5>{{movie.title}} <span class="badge badge-secondary">{{movie.popularity}}</span></h5>
                                    <div v-if="movie.vote_average == 0">Still no votes</div>
                                    <div v-else>{{movie.vote_average}} over {{movie.vote_count}}</div>
                                    <span class="badge badge-info">{{movie.status}}</span> <span v-for="genre in movie.genres" class="badge badge-success">{{genre.name}}</span>
                                    <p>{{movie.overview}}</p>
                                    <div v-for="language in movie.spoken_languages">
                                        {{language.english_name}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="modelOpen = false">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'home',
        data() {
            return {
                current_page: 1,
                error: false,
                movies: false,
                modelOpen: false,
                movie: false
            }
        },
        async beforeCreate() {
            await this.$store.dispatch("loadUser");

            if (this.$store.getters.isLoggedIn === false) {
                this.$router.push('login');
            }
        },
        created() {
            this.loadData();

            // Needed to execute the code from the render
            window.fullDetails = this.fullDetails;
        },
        methods: {
            loadData() {
                if (typeof this.$route.query.page !== "undefined") {
                    this.current_page = this.$route.query.page;
                }
                axios.get("/api/movies?page=" + this.current_page)
                    .then((data) => {
                        this.movies = data.data.data; // So original these developers

                    }).catch(error => {
                    this.error = error.response.data.msg;
                    this.blockSubmit = false;
                });
            },
            formatDate(date) {
                date = date.split("-");
                return date[2] + "/" + date[1] + "/" + date[0];
            },
            fullDetails(id) {
                this.modelOpen = true;
                this.movie = false;
                axios.get("/api/movie/" + id)
                    .then((data) => {
                        this.movie = data.data.data; // So original these developers

                    }).catch(error => {

                });
            },
            pages(start, end) {
                var a = [start], b = start;
                while (b < end) {
                    a.push(b += 1);
                }
                return a;
            }
        },
        watch: {
            $route(to, from) {
                this.loadData();
            }
        }
    }
</script>

<style>
    .modal {
        background-color: rgba(0, 0, 0, .5);
    }
    img {
        max-width:100%;
    }
</style>