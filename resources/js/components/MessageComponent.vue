<template>

        <div class="card card-default chat-box" >
            <div class="card-header">
                <b :class="{'text-danger':session_block}">
                    {{friend.name}}
                    <span v-if="session_block">(Blocked)</span>
                </b>
                <!-- Close Button -->
                <a href="" @click.prevent="close">
                    <i class="fa fa-times float-right" aria-hidden="true"></i>
                </a>
                <!-- Close Button Ends -->

                <!-- Options -->
                <div class="dropdown float-right mr-4">
                    <a href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                    </a>

                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#" @click.prevent="unblock" v-if="session_block">UnBlock</a>
                        <a class="dropdown-item" href="#" @click.prevent="block" v-else>Block</a>

                        <a class="dropdown-item" href="#" @click.prevent="clear">Clear Chat</a>
                    </div>
                </div>
                <!-- Options Ends -->
            </div>
            <ul class="card-body" v-chat-scroll>
                <p class="card-text" :class="{'text-right':chat.type == 0}" v-for="chat in chats"
                :key="chat.message">
                    {{chat.message}}
                </p>
            </ul>
            <form class="card-footer" @submit.prevent="send">
                <div class="form-group">
                    <input type="text" class="form-control"
                           placeholder="Write you message there"
                            :disabled="session_block"
                            v-model="message">
                </div>
            </form>
        </div>
</template>

<script>
    export default {
        name: "MessageComponent",

        props:['friend'],

        data(){
           return{
               chats:[],
               message:null,
               session_block:false,
           }
        },

        methods:{
            send(){
                if(this.message){
                   this.pushToChat(this.message);
                   axios.post(`/send/${this.friend.session.id}`,{
                       contents: this.message,
                       to_user: this.friend.id,
                   });
                   this.message = null;
                }
            },
            pushToChat(message){
                this.chats.push({message: message, type:0, sent_at:'Just Now'});
            },
            close(){
                this.$emit('close');
            },
            clear(){
                this.chats = [];
            },
            block(){
                this.session_block = true;
            },
            unblock(){
                this.session_block = false;
            },
            getAllMessages(){
                this.chats.push(
                    axios.post(`session/${this.friend.session.id}/chats`)
                        .then(res=>(this.chats = res.data.data))
                );
            }
        },

        created(){
            this.getAllMessages();
        }
    }
</script>

<style >
    .chat-box{
        height: 400px;
    }

    .card-body{
        overflow-y: scroll;
    }

</style>