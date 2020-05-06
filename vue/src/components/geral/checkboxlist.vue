<template>
    <div style="overflow-y:scroll; max-height: 200px">
        <div v-for="(item,index) in lista" :key="index">
                  <input type="checkbox" :value="item.id" 
                             v-model="values" > {{item.codigo}} - {{item.descricao}}

        </div>            

    </div>


</template>
<script>
export default {
    props:{
        lista:{
            type: Array

        },
        value:{
            type: String
        }
    },
    data() {
            return {
                   values: []
            };
    },
    watch: {
                    values(val) {
                        if ( val == null )
                            val = [];

                         this.$emit("selected", val.join(','));
                    },
                    value(val) {
                         if ( val == null )
                            val = "";

                          this.values = val.split(',');
                    }
    },
    model: {
                prop: "value",
                event: "selected"
    },
    
    mounted(){
            this.values = this.value.split(',');
    }
}
</script>