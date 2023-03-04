<template>
    <div>
        <button class="btn btn-primary mx-4" @click="followUser" v-text="buttonText">Follow</button>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
