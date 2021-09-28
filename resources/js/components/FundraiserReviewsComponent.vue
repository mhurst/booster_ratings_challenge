<template>
	<div class="rating-form-cont text-left">
		<div class="heading text-left">
			<h1>Reviews</h1>
		</div>
		<ul class="list-inline">
			<div v-if="!reviews || !reviews.length">
				<li>No reviews yet for this fundraiser. Be the first to review below</li>
			</div>
			<div v-else v-for="review in reviews">
				<li class="list-inline-item heading">
					{{ review.reviewers_name }} - {{ review.review_date }}
					<ul>
						<li>Rating: <span class="rating">{{ ratingAlter(review.rating) }}</span></li>
						<li>Review:<br> {{ review.review }}</li>
					</ul>
				</li>
			</div>
		</ul>
		<fundraisers-review-add-form />
	</div>
</template>

<script>
	import fundraisersreviewaddform from './FundraisersReviewAddFormComponent.vue'

	export default {
		data() {
			return {
				reviews: [],
			}
		},

		componenets: {
			'fundraisers-review-add-form' : fundraisersreviewaddform
		},

		mounted() {
			this.getReviews();
		},

		methods: {
			getReviews() {
			let id = this.getId();
				  axios.get("/api/ratings-by-fundraiser/" + id)
				  .then((response) => {
				    this.reviews = response.data.data;
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

			getId() {
				let uri = window.location.href.split('/');

			    return uri.at(-1);
			}
		}
	}
</script>
<style>
	.rating-form-cont {
		width: 100%;
		max-width: 800px;
		text-align: left;
		margin: 0 auto;
	}

	.rating-form-cont .heading {
		padding-bottom: 20px;
		font-weight: bold;
	}

	.rating-form-cont ul li {
		padding-bottom: 10px;	
	}

	.rating-form-cont ul li .rating {
		color: #ffc125;
		font-weight: bold;
		font-size: 24px;
	}

	.rating-form-cont ul li ul li {
		list-style-type: none;
		padding-bottom: 5px;
		font-weight: normal;
	}
</style>