<template>
	<div class="rating-form-cont text-left">
		<div class="heading text-left">
			<h1>Reviews</h1>
		</div>
		<ul class="list-inline">
			<div v-for="review in reviews">
				<li class="list-inline-item">Rating: {{ review.rating }}
					<ul>
						<li>Review: {{ review.review }}</li>
						<li>Reviewer: {{ review.reviewers_name }}</li>
						<li>Review Date: {{ review.review_date }}</li>
					</ul>
				</li>
			</div>
		</ul>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				reviews: [],
			}
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
			getId() {
				let uri = window.location.href.split('/');

			    return uri.at(-1);
			}
		}
	}
</script>