<style lang="sass">
	.panel-default>.panel-heading {
		border: none;
		border-left: 3px solid #333;
		border-bottom: 1px solid #ddd;
	}
	.panel-title { font-size: 14px; }
	.panel-body { margin-left: 15px; }
	.panel-body .nav-pills>li.active>a {
		color: #fff;
		border: none;
		background-color: #169bd5;
	}
	.panel-body .nav-pills>li { margin-left: 10px; }
	.panel-body .nav-pills>li>a { border-radius: 5px; }
	.panel-body .nav>li>a {
		width: 100px;
		color: #333;
		padding: 5px 15px;
		text-align: center;
		border: 1px solid #333;
	}
	.content-img {
		margin-left: 9px;
		padding-bottom: 10px;
		border-bottom: 1px dashed #333;
	}
</style>
<template lang="html">
<div class="panel panel-default">
	<slot name="panel-header">
		<div class="panel-heading">
	        <slot name="title">
            	<h5 class="panel-title" >
	                {{title}}
	            </h5>
	        </slot>
        </div>
	</slot>
	<slot name="panel-body">
        <div class="panel-body"></div>
    </slot>
</div>
</template>
<script>
export default {
	props: {
		title: {
	        type: String,
	        default: ''
	    }
	}
}

</script>