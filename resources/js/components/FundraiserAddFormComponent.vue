<template>
	<div class="rating-form-container">
		<h3>Add Fundraiser</h3>
        <div class="row">
            <div>
                <form @submit.prevent="addFundraiser">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="post.name">
                    </div>
                    <button type="submit" class="btn btn-primary">Add</button>
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
            addFundraiser() {
 				if (this.post.name) {
	                axios.post('/api/fundraisers', this.post)
	                .then((response) => {
					    window.location.reload();
					  })
					  .catch((error) => {
					  	this.errors.push(error.response.data.error);
					  })
	            }

	            this.errors = [];

	            if (!this.post.name) {
		        	this.errors.push('Name required.');
				}     
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