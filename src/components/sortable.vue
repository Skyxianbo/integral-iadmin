<style lang="sass">

</style>
<template lang="html">
<div>
	<slot name="sortable">
        <table class="table">
        	<thead>
        		<tr>
        			<th>name</th>
		        	<th>age</th>
        		</tr>
        	</thead>
        	<tbody id="items">
        		<tr v-for="item in list" data-value="{{$index}}" class="sortable">
        			<td>{{item.name}}</td>
        			<td>{{item.age}}</td>
        		</tr>
        	</tbody>
        </table>
        <button class="btn btn-primary" @click.prevent="sortableSave()">打印</button>
    </slot>
</div>
</template>
<script>
export default {
	props: {
		
	},
	data() {
		return {
			list: [{
				name: "李贤波",
				age: "23"
			}, {
				name: "林海慧",
				age: "24"
			}, {
				name: "潘小红",
				age: "23"
			}, {
				name: "高晓琴",
				age: "23"
			}, {
				name: "谢作柯",
				age: "24"
			}],
			result: [],
			sortable: {}
		}
	},
	ready() {
		var el = document.getElementById("items");
		this.sortable = Sortable.create(el);
	},
	methods: {
		sortableSave() {
			this.result = [];
			$("tr[class=sortable]").each((x) => {
				this.result.push(this.list[$("tr[class=sortable]").eq(x).attr("data-value")]);
			})
			this.sortable.option("disabled", true);
		}
	}
}

</script>