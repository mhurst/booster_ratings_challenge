<template>
	<div class="rating-form-container">
		<h3 class="text-center">Add Fundraiser</h3>
        <div class="row">
            <div class="col-md-6">
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
    			name: null,
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
					  console.log(error);
					  	this.errors.push(error);
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