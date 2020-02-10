<template>
    <div id="loadingOverlay" class="flex items-center justify-center  fixed top-0 bottom-0 left-0 right-0 bg-black-opacity-5">
        <LoadingSpinner 
            borderWidth="3px" 
            borderTopColor="#00ce07" 
            borderBg="#f3f3f3" 
            size="40px"
        />
    </div>
</template>

<script>
    import LoadingSpinner from './LoadingSpinner.vue';
    export default {
        components: {LoadingSpinner}
    }
</script>