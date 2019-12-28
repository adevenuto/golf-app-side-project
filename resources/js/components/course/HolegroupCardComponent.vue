<template>
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between p-2">
            <h4>Holegroup</h4>
            <a href="#" 
                data-toggle="modal" 
                :data-target="modalId()">Edit</a>
        </div> 
        <div class="card-body p-2">
            Name: <span class="text-secondary">{{holegroup.group_name}}</span>
            <br>
            Teebox: <span class="text-secondary">{{holegroup.teebox}}</span>
            <br>
            Holes: <span class="text-secondary">{{holegroup.number_of_holes}}</span>
        </div>
        <editHoleGroupModal :holegroup="holegroup"/>
    </div>
</template>

<script>
    import editHoleGroupModal from './editHoleGroupModal';
    export default {
        props: ['holegroup'],
        data() {
            return {

            }
        },
        components: {editHoleGroupModal},
        methods: {
            modalId: function() {
                return '#editHoleGroupModal_'+this.holegroup.id;
            }
        }
    }
</script>

<style lang="scss" scoped>
    
</style>