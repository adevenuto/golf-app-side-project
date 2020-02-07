<template>
    <div class="shadow-md rounded overflow-hidden sm:mx-3">
        <div class="flex justify-between p-3 bg-gray-200">
            <div class="text-lg">Holegroup</div>
            <a href="#" 
                class="text-blue-700"
                data-modal="true" 
                :data-target="modalId()">Edit</a>
        </div> 
        <div class="card-body p-2">
            Name: <span class="text-gray-600">{{holegroup.group_name}}</span>
            <br>
            Teebox: <span class="text-gray-600">{{holegroup.teebox}}</span>
            <br>
            Holes: <span class="text-gray-600">{{holegroup.number_of_holes}}</span>
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
