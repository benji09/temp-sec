<template>
  <div>
    
    
    <a-button type="primary">
      按钮
    </a-button>
    <a-button type="link">
      Link
    </a-button>
  </div>
</template>


<script>
import { Button } from 'ant-design-vue';
Vue.use(Button);



export default {
  name: 'AntComs',
  props: {
	msg: String
  }
}
</script>

<style>
</style>
