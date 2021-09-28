<template>
	<div class="rating-form-container">
		<h3>Add Review</h3>
	    <div class="row">
	        <div>
	            <form @submit.prevent="addReview">
	                <div class="form-group">
	                    <label>Rating</label>
	                    <select class="form-control" v-model="post.rating">
	                    	<option value="1">1</option>
	                    	<option value="2">2</option>
	                    	<option value="3">3</option>
	                    	<option value="4">4</option>
	                    	<option value="5">5</option>
	                    </select>
	                    <label>Review</label>
	                    <textarea type="text" class="form-control" v-model="post.review"></textarea>
	                    <label>Reviewers Name</label>
	                    <input type="text" class="form-control" v-model="post.reviewers_name">
	                   	<label>Reviewers Email</label>
	                    <input type="text" class="form-control" v-model="post.reviewers_email">
	                    <label for="used">I have used this fundraiser
	                    	<input type="checkbox" name="used"   checked="checked">
	                    </label>
	                </div>
	                <button type="submit" class="btn btn-primary">Add</button>
	                <p>If this is your first review, you will need to verify your email address before your review will show. Please check your email.</p>
	                <p v-if="errors.length">
					    <b>Please correct the following error(s):</b>
					    <ul>
					      <li v-for="error in errors">{{ error }}</li>
					    </ul>
					 </p>
	            </form>
	        </div>
	    </div>
	</div>
</template>

<script>
export default {
    data() {
        return {
            post: {},
            errors: [],
        }
    },

    methods: {
        addReview() {
				if (
					this.post.rating &&
					this.post.review &&
					this.post.reviewers_name &&
					this.post.reviewers_email
				) {
				let new_post = {
					"fundraisers_id" : this.getId(),
					"rating" : this.post.rating,
					"review" : this.post.review,
					"review_date" : this.getCurrentDateTime(),
					"name" : this.post.reviewers_name,
					"email" : this.post.reviewers_email 
				}
                axios.post('/api/ratings', new_post)
                .then((response) => {
				    window.location.reload();
				  })
				  .catch((error) => {
				  	this.errors.push(error.response.data.error);
				  })
            }

            this.errors = [];

            if (!this.post.rating) {
	        	this.errors.push('Rating required.');
			}
			
			if (!this.post.review) {
	        	this.errors.push('Review required.');
			}

			if (!this.post.reviewers_name) {
	        	this.errors.push('Reviewers Name is required.');
			}

			if (!this.post.reviewers_email) {
	        	this.errors.push('Reviewers Email is required.');
			}
        },

        getCurrentDateTime() {
        	return new Date().toISOString().slice(0, 19).replace('T', ' ');
        },

    	getId() {
			let uri = window.location.href.split('/');

		    return uri.at(-1);
		}
    }
}
</script>

<style>
	.rating-form-container {
		width: 100%;
		background-color: #efefef;
		padding: 16px;
		text-align: left;
		margin-bottom: 32px;
		border: 1px solid #999;
	}

	.rating-form-container form label {
		padding-bottom: 8px;
	}

	.rating-form-container form input {
		margin-bottom: 8px;
	}
</style>