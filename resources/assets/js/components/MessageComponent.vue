<template>
       <div class="card card-default chat-box" >
            <div class="card-header">
                <b :class="{'text-danger':session_block}">
                    {{friend.name}}
                    <span v-if="session_block">(Blocked)</span>
                </b>
                <a href=""  @click.prevent="close">
                    <i class="fa fa-close float-right" aria-hidden="true"></i>
                </a>


                <div class="dropdown float-right mr-4">
                  
                    <a href=""  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-ellipsis-h " aria-hidden="true"></i>
                    </a>
                    
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#" v-if="session_block" @click.prevent="unblock">Unblock</a>
                        <a class="dropdown-item" href="#" v-else @click.prevent="block">Block</a>
                        
                        <a class="dropdown-item" href="#" @click.prevent="clear">Cleat chat</a>
                    </div>
                </div>

                

                   
            </div>

            <div class="card-body" v-chat-scroll>
               <p class="card-text" :class="{'text-right':chat.type==0}" v-for="chat in chats" :key="chat.id" >
                   {{chat.message}}
               </p>
            </div>
            <form class="card-footer" @submit.prevent="send">
                <div class="form-group">
                    <input type="text" class="form-control" v-model="message" :disabled="session_block" placeholder="Write your message here"/>
                </div>
                
            </form>
        </div>
</template>

<script>
export default {

    props:['friend'],
    data(){
        return{
            chats: [],
            session_block:false,
            message:null
            
        }
    },
    methods:{
        send(){
            if(this.message){
                this.pushToChats(this.message);
                axios.post(`/send/${this.friend.session.id}`,{
                    content:this.message,
                    to_user: this.friend.id
                });
                this.message=null;
            }
        },
        pushToChats(message){
            this.chats.push({message: message,type:0,sent_at:'Just Now'});
        },
        close(){
            this.$emit('close');
        },
        clear(){
            this.chats=[]
        },
        block(){
            this.session_block=true
        },
        unblock(){
            this.session_block=false
        },
        getAllMessages(){
            axios.post(`/session/${this.friend.session.id}/chats`).then(res=>this.chats=res.data.data);
        }
    },
    created(){
       this.getAllMessages();

   

     Echo.private(`Chat.${this.friend.session.id}`).listen(
      "PrivateChatEvent",
      e => {
        
        this.chats.push({ message: e.content, type: 1, sent_at: "Just Now" });
      }
    );

    }
}
</script>

<style>
.chat-box{
    height:400px;
}
.card-body{
    overflow-y: scroll;
}

</style>
