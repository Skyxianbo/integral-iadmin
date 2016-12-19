<style type="text/css" lang='sass' scoped>
	.v-time{
		position: relative;
		background-color: #fff;
		border: 1px solid #ddd;
		padding:0 20px;
		cursor: pointer;
		&:hover{
			background:rgba(240,240,240,1);
		}
	}
</style>
<template>
    <div class='v-time'>
        2016-06-01至 2016-06-30 <i class='fa  fa-calendar'></i>
        <!-- <v-date-picker></v-date-picker> -->
    </div>
</template>
<script type="text/javascript">
import vDatePicker from './vDatePicker.vue';
	export default{
		components:{
			vDatePicker
		}
	}
</script>
