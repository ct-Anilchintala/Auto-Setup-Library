<style type="text/css">
    body {background: #F5F5F5;}
    #app {white-space: pre-wrap;word-wrap: break-word; font-family: "Times New Roman";font-weight: bold;}
    tbody tr:nth-child(odd) {background: #FFFFFF !important;}
    .error{font-size: 14px}
</style>
<head>
    <script src="../vue.js" ></script>
    <script src="../axios.min.js" ></script>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="bootstrap/js/bootstrap.min.css">
</head>
<div id="app">   
    <loading :active.sync="loader" :can-cancel="true"></loading> 
    <div class= "p-2 w-100"><a href="index.php" class="btn btn-danger p-2" >Back</a></div>  
    <div class= "text-danger" style="text-align:center;" v-if="error.length > 0">{{ error }}</div>
    <h1><div style="text-align:center">Config Details </div></h1>
    <div style="line-height: 26pt; margin:auto;margin-top:10px; padding:15px;font-size: 18px; " class="card col-md-4">
        <div>
            <table class="table table-bordered table-sm bg-light">
                <tr>
                    <td>Field</td>
                    <td>Type</td>
                </tr>
                <tr v-for="(value, key) in result" :key="key">
                    <td>
                        <input type="text"  :value="key"  class="form-control" placeholder="Property Name" disabled>
                    </td>
                    <td v-if="typeof value === 'object'">
                        <div>
                            <table>
                                <tr v-for="(val, subKey) in value" :key="subKey">
                                    <td v-for="v,k in val">
                                        <input type="text" v-model="result[key][subKey][k]" class="form-control" placeholder="Value">
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </td>
                    <td v-else>
                        <input type="text" v-model="result[key]" :value="value" class="form-control" placeholder="Value">
                    </td>
                </tr>
            </table>
        </div>
        <button class="btn btn-secondary mt-3" type="button" v-on:click="updateDetails()">Submit</button>
        <div class="mt-5"></div>
        {{result}}
    </div>
</div>
<script>
    var app = Vue.createApp({
        data: function(){
            return{ 
                error:{},
                result:[],
                loader : false,
                configs:[],
            };
        },
        mounted:function(){
            this.getdata();
        },
        methods:{
            getdata(){
                vpost={
                    "action":"get_data"
                };
                axios.post("screen_2_control.php",vpost).then(response=>{
                    if(response.data.status == "success"){
                        this.result =response.data.res;
                    }
                })
            },
            updateDetails: function (key,value) {
                vpost={
                    "action":"submit_data",
                    "data":this.result
                }
                axios.post("screen_2_control.php",vpost).then(response => {

                })
            }
        }
    }).mount("#app");
</script>