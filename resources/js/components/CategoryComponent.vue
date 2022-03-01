<template>
    <div class="col-4 mb-4">
        <div class="card">
            <div class="card-img p-4 pb-0">
                <img :src="'/storage/' + category.picture" class="card-img-top" :alt="category.name">
            </div>
            <div class="card-body">
                <h5 class="card-title">{{ category.name }}</h5>
                <p class="card-text">{{ category.description }}</p>
                <a :href="routeCategory + '/' + category.id" class="btn btn-primary">Перейти</a>
                <button @click="buttonClicked" class="btn btn-link">Добавить в избранные</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['category', 'routeCategory'],
        methods: {
            buttonClicked() {
                this.$emit('buttonClicked', this.category.id)
            }
        }
    }
</script>