<template>
	<div class="fund-list-cont text-left">
		<div class="heading text-left">
			<h1>Fundaisers</h1>
		</div>
		<ul class="list-inline">
			<div v-for="fundraiser in fundraisers" :key="fundraiser.fundraiser_id">
				<li class="list-inline-item name">{{ fundraiser.fundraiser_name }}
					<ul>
						<li>Rating: <span class="rating">{{ ratingAlter(fundraiser.average_rating) }}</span></li>
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

				for (let i = 0; i < rating; i++) {
					stars += '* ';
				}
				
				return stars;
			},
		},
	}
</script>

<style>
	.fund-list-cont {
		width: 100%;
		max-width: 800px;
		text-align: left;
		margin: 0 auto;
	}

	.fund-list-cont .heading {
		padding-bottom: 20px;
	}

	.fund-list-cont ul li {
		padding-bottom: 10px;	
	}

	.fund-list-cont ul li.name {
		font-weight: bold;
	}

	.fund-list-cont ul li .rating {
		color: #ffc125;
		font-weight: bold;
		font-size: 24px;
	}

	.fund-list-cont ul li ul li {
		font-weight: normal;
		list-style-type: none;
	}

	.fund-list-cont ul li ul li a {
		display: block;
		padding: 2px;
		background-color: green;
		text-align: center;
		color: #fff;
		text-decoration: none;
		border-radius: 4px;
		width: 200px;
	}
</style>