<template>
    <div id="loadingOverlay" class="d-flex align-items-center justify-content-center">
        <LoadingSpinner 
            borderWidth="2px" 
            borderTopColor="#00ce07" 
            borderBg="#f3f3f3" 
            size="20px"
        />
    </div>
</template>

<script>
    import LoadingSpinner from './LoadingSpinner.vue';
    export default {
        components: {LoadingSpinner}
    }
</script>

<style lang="scss" scoped>
    #loadingOverlay {
        position: fixed;
        background: rgba(255, 255, 255, 0);
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 5000;
    }
</style>