<template>
    <div>
                    <section class="section">
                                    <div class="box" v-for="article in articles" v-bind:key="article.id">
                                                    <article class="media">
                                                        <div class="media-content">
                                                        <div class="content">
                                                            <p>
                                                            <strong>{{ article.title }}</strong> <small>31m</small>
                                                            <br>
                                                                {{ article.body }}
                                                            </p>
                                                        </div>
                                                        <nav class="level is-mobile">
                                                            <div class="level-left">
                                                            <a @click="deleteArticle(article.id)" class="level-item" aria-label="reply">
                                                                <span class="icon is-small">
                                                                <i class="fas fa-trash-alt" aria-hidden="true"></i>
                                                                </span>
                                                            </a>
                                                            <a @click="editArticle(article)" class="level-item" aria-label="retweet">
                                                                <span class="icon is-small">
                                                                <i class="fas fa-edit" aria-hidden="true"></i>
                                                                </span>
                                                            </a>
                                                            <a class="level-item" aria-label="like">
                                                                <span class="icon is-small">
                                                                <i class="fas fa-heart" aria-hidden="true"></i>
                                                                </span>
                                                            </a>
                                                            </div>
                                                        </nav>
                                                        </div>
                                                    </article>
                                    </div>

                                    <nav class="pagination is-rounded" role="navigation" aria-label="pagination">
                                                <a  @click="fetchArticles(pagination.prev_page_url)" class="pagination-previous" v-bind:disabled="!pagination.prev_page_url">Previous</a>
                                                <a @click="fetchArticles(pagination.next_page_url)" class="pagination-next" v-bind:disabled="!pagination.next_page_url">Next page</a>
                                    </nav>

                                    <hr>

                                    <div class="box">
                                    <form @submit.prevent="addArticle()">    
                                        <article class="media">
                                                <div class="media-content">
                                                <div class="field">
                                                    <p class="control">
                                                    <label class="label">Title</label>
                                                        <input v-model="article.title" class="input" placeholder="Add a title..." />
                                                    </p>
                                                    </div>
                                                    <div class="field">
                                                    <p class="control">
                                                    <label class="label">Body</label>
                                                        <textarea v-model="article.body" class="textarea" placeholder="Add a body..."></textarea>
                                                    </p>
                                                    </div>
                                                    <nav class="level">
                                                    <div class="level-left">
                                                        <div class="level-item">
                                                        <button class="button is-info" type="submit">Save</button>
                                                        </div>
                                                    </div>
                                                    </nav>
                                                </div>
                                        </article>
                                    </form>
                                    </div>
    
                    </section>
    </div>            
</template>

<script>
    export default {
        data(){
            return {
                articles:[],
                article: {
                    id: '',
                    title: '',
                    body: ''
                },
                article_id: '',
                pagination: {},
                edit: false
            }
        },
        created(){
            this.fetchArticles();
        },
        methods: {
            fetchArticles(page_url){
                let vm = this;
                page_url = page_url || '/api/articles'
                axios
                    .get(page_url)
                    .then(response => {
                        this.articles = response.data.data
                        vm.makePagination(response.data.meta, response.data.links)
                    })
                    .catch(error => console.log(error))        
            },
            makePagination(meta, links){
                let pagination = {
                    current_page: meta.current_page,
                    last_page: meta.last_page,
                    next_page_url: links.next,
                    prev_page_url: links.prev
                }
                this.pagination = pagination
            },
            deleteArticle(id){
                this.article_id = id
                axios
                    .delete(`http://localhost:8000/api/article/${id}`)
                    .then(response => response.data.data)
                    .then(data => {
                        this.fetchArticles()
                    })
                    .catch(error => console.log(error))   
            },
            addArticle(){
                if(this.edit === false){
                    //Add
                    axios
                    .post('api/articles', this.article)
                    .then(response => response.data.data)
                    .then(data => {
                        this.article.title = ''
                        this.article.body = ''
                        this.fetchArticles()
                    })
                    .catch(error => console.log(error)) 
                } else {
                    //Update
                     axios
                    .put('api/articles', this.article)
                    .then(response => response.data.data)
                    .then(data => {
                        this.article.title = ''
                        this.article.body = ''
                        this.fetchArticles()
                    })
                    .catch(error => console.log(error)) 
                }
            },
            editArticle(article){
                this.edit = true
                this.article.id = article.id
                this.article.article_id = article.id,
                this.article.title = article.title,
                this.article.body = article.body
            }
        }
    }
</script>