<template>
    <div class="spinner" :style="style"></div>
</template>

<script>
    export default {
        name: 'spinner',
        props: ['borderWidth', 'borderTopColor', 'borderBg', 'size'],
        computed: {
            style() {
                return (`border: ${this.borderWidth} solid ${this.borderBg}; 
                        border-top: ${this.borderWidth} solid ${this.borderTopColor}; 
                        width: ${this.size}; height: ${this.size}`);
            }
        }
    }
</script>
<style lang="scss" scoped>
    .spinner {
        border-radius: 50%;
        width: 25px;
        height: 25px;
        animation: formSpinner .45s linear infinite;
        position: relative;
    }
    @-webkit-keyframes formSpinner {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
    }
    @keyframes formSpinner {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>