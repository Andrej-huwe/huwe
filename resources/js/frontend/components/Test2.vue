<template>
  <div> <h1>{{header}}</h1>
  </div>
</template>
<script>
import { bus } from '../app';
export default {
  name: 'Test2',
  props: {
    header:{
      type: String
    }
  },
  created (){
    bus.$on('changeIt', (data) => {
      this.header = data;
    })
  }
}
</script>