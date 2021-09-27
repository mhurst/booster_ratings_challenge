<template>
	<div class="fund-list-cont text-left">
		<div class="heading text-left">
			<h1>Fundaisers</h1>
		</div>
		<ul class="list-inline">
			<div v-for="fundraiser in fundraisers" :key="fundraiser.fundraiser_id">
				<li class="list-inline-item">{{ fundraiser.fundraiser_name }}
					<ul>
						<li>Rating: {{ ratingAlter(fundraiser.average_rating) }}</li>
						<li><a :href="'/fundraisers-review-form/' + fundraiser.fundraiser_id">Add Review</a></li>
					</ul>
				</li>
			</div>
		</ul>
		<fundraisers-add-form />
	</div>
</template>

<script>
	import fundraisersaddform from './FundraiserAddFormComponent.vue'
	export default {
		data() {
			return {
				fundraisers: [],
			}
		},

		componenets: {
			'fundraisers-add-form' : fundraisersaddform
		},

		mounted() {
			this.getFundraisers();
			this.ratingAlter();
		},

		methods: {
			getFundraisers() {
				  axios.get("/api/fundraisers")
				  .then((response) => {
				    this.fundraisers = response.data.data;
				  })
				  .catch((error) => {
				  	console.log(error);
				  })
			},

			ratingAlter(rating) {
				let stars = '';

				if (rating === null) {
					return 'No rating yet';
				}

				for (let i = 1; i < rating; i++) {
					stars += '* ';
				}

				return stars;
			},

            reload() {
		      this.$forceUpdate();
		    },

		    goToRoute(param1) {
	            let route = '{{ route("fundraisers-review-form", ["id" => "?anytagtoreplace?"]) }}'
 			    location.href = route.replace('?anytagtoreplace?', param1) 
			}
		},
	}
</script>
