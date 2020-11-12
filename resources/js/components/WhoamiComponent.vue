<template>
  <div class="container">

    <div class="row">
      My Ip Address is {{ ip }}
      {{ info }}
    </div>
  </div>
</template>

<script>
import axios from 'axios';
export default {
  data: function() {
    return {
    };
  },
  mounted() {
    axios
      .get('http://api.ipstack.com/' + this.ip + '?access_key=' + this.access_key)
      .then(response => (this.info = response));
    console.log('Component mounted.');
  },
};
</script>
