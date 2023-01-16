<template>

    <main>
        <section class="vh-50">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col col-xl-10">
        
                        <div class="card" style="border-radius: 15px;">
                            <div class="card-body p-5">
                
                                <h4 class="mb-3">Todo List</h4>
                    
                                <div class="d-flex justify-content-center align-items-center mb-0">
                                    <div class="form-outline flex-fill">
                                        <input type="text" id="item" name="item" class="form-control form-control-lg"  placeholder="Type Something..." @keyup.enter="postItem" v-model="newItem"/>
                                    </div>
                                    <button @click="postItem" class="btn btn-primary btn-lg ms-2">Add</button>
                                </div>

                                <p v-if="err" class="text-danger" style="font-size:13px">{{ err }}</p>
                    
                                <ul class="list-group mb-0 mt-3" v-for="item,index in items" :key="item.id">
                                    <li v-if="user.id == item.user.id"
                                    class="list-group-item d-flex justify-content-between align-items-center border-start-0 border-top-0 border-end-0 border-bottom rounded-0 mb-2">
                                        <div class="d-flex align-items-center">
                                            <p class="d-flex text-center mb-0 text-success" style="font-size: large;">
                                                {{ index + 1 }} :
                                            </p><span class="px-2" style="font-size: large;">{{ item.item }}</span>
                                        </div>
                                        <a @click="deleteItem(item.id)" title="Remove item" id="removeIcon">
                                            <i class="bi bi-trash" style="font-size:large;"></i>
                                        </a>
                                    </li>
                                </ul>
                
                            </div>
                        </div>
        
                    </div>
                </div>
            </div>       
        </section>
    </main>

</template>

<script>
    import axios from 'axios'
    import {ref,onMounted} from 'vue'

    export default{
        props:['user'],

        setup(props) {

            let items = ref([])
            let newItem = ref('')
            const err = ref('')

            //  DATA DISPLAY PART
            onMounted(() =>{
	    		fetchItem()
	    	})

            // GET DATA FROM DATABASE AND RETURN AS RESPONSE
            const fetchItem = async()=>{

                axios.get('/fetchItem').then(response=>{
                    items.value = response.data
                    // console.log(response.data);
                })

            }

            //  POST ITEM PART
            const postItem = async()=>{

                if(newItem.value.length<10){
                    return err.value = "Note needs to be 10 character or more"
                }

                let userItem = {
                    user: props.user,
                    item: newItem.value
                }

                items.value.push(userItem);
                //  POST TE ITEM AND RETURN ALL ITEMS DATA AS RESPONSE
                axios.post('/postItem',userItem).then(response =>{
                    items.value = response.data
                    console.log(items.value);
                })

                newItem.value = ''
                err.value = ""

            }

            // BROADCASTING THR ACTION AFTER POST THE DATA
            window.Echo.private('todoList').listen('ItemPost',(e) =>{

                axios.get('/fetchItem').then(response=>{
                    items.value = response.data
                })

            })

            //  BROADCASTING THE ACTION AFTER DELETE POST
            window.Echo.private('todoList').listen('ItemRemove',(e) =>{

                axios.get('/fetchItem').then(response=>{
                    items.value = response.data
                })

            })

            
            //  DELETE DATA WITH RELATIVE ITEM ID
            const deleteItem = async(id)=>{

                axios.delete('/deleteItem/'+id).then(response =>{
                    items.value = response.data
                })
                // console.log(id);
            }

            // function removeItem(index){

            //     items.splice(index,1)

            // }
            //  RETURN ALL THE FUNCTION
            return{
                items,
                newItem,
                err,
                postItem,
                fetchItem,
                deleteItem
            }
        }
        
    }
</script>

<style scoped>
    i:hover{
        color: red;
        transition-duration: 0.5s;
    }

    @keyframes rotate {
        0% {
          transform: rotate(0deg)
        }
        100% { 
          transform: rotate(360deg)
        }
      }
</style>