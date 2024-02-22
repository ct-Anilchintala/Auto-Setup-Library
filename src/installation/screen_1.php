<style type="text/css">
    body {background: #F5F5F5;}
    #app {white-space: pre-wrap;word-wrap: break-word; font-family: "Times New Roman";font-weight: bold;}
    tbody tr:nth-child(odd) {background: #FFFFFF !important;}
    .error{font-size: 14px}
</style>
<head>
    <script src="vue.js" ></script>
    <script src="axios.min.js" ></script>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="bootstrap/js/bootstrap.min.css">
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->


</head>
<div id="app">   
    <loading :active.sync="loader" :can-cancel="true"></loading>
    <div class= "p-2 w-100"><a href="index.php" class="btn btn-danger p-2" >Back</a></div>  
    <h1><div style="text-align:center">Application Config Details </div></h1>
    <div style="line-height: 26pt; margin:auto;margin-top:10px; padding:15px;font-size: 18px; " class="card col-md-4">
        <div><table class="table table-bordered table-sm bg-light">
            <tr>
                <td>Field</td><td>Type</td><td>Value</td>
            </tr>
            <tr v-for="v,i in details" >
                <td><input type="text" v-model="v['name']" class="form-control" placeholder="Property Name">
                    <span v-if="error[`name_${i}`]" class="text-danger error">{{ error[`name_${i}`] }}</span>
                </td>
                <td>
                    <select class="form-control" v-model="v['data_type']" @change="check_data_type(i)">
                        <option value="" selected>select</option>
                        <option value="1">String</option>
                        <option value="2">Number</option>
                        <option value="3">Boolean</option>
                        <option value="4">Array</option>
                    </select>
                    <span v-if="error[`data_type_${i}`]" class="text-danger error">{{ error[`data_type_${i}`] }}</span>
                </td>
                <td v-if = "v['data_type'] == 4">
                    <div>
                        <table>
                            <tr v-for="val,j in details[i]['value']">
                                <td>
                                    <input type="text" v-model="details[i]['value'][j]['value']" class="form-control" placeholder="Value">
                                    <span v-if="error[`value_${i}_${j}`]" class="text-danger error">{{ error[`value_${i}_${j}`] }}</span>
                                </td>
                                <td class="text-center"><input type="button" class="btn btn-sm btn-danger" value="X" v-on:click="delete_detail1(key)"></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td class="text-center"><input type="button" class="btn btn-sm btn-secondary" value="+" v-on:click="add_detail1(v,i)"></td>
                            </tr>
                        </table>
                    </div></td>
                <td v-else>
                    <input type="text" v-model="v['value']" class="form-control" placeholder="Value">
                    <span v-if="error[`value_${i}`]" class="text-danger error">{{ error[`value_${i}`] }}</span>
                </td>
                <td class="text-center"><input type="button" class="btn btn-sm btn-danger" value="X" v-on:click="delete_detail(i)"></td>
            </tr>
            <tr>
                <td></td><td></td><td></td>
                <td class="text-center"><input type="button" class="btn btn-sm btn-secondary" value="+" v-on:click="add_detail"></td>
            </tr>
        </table></div>
        <button class= "btn btn-secondary mt-3" type="button"  v-on:click="validation()">Submit</button>
        <!-- {{details}} -->
        <div class="mt-5"></div>
    </div>
</div>
<script>
     var app = Vue.createApp({
        data: function(){
            return{ 
                error:{},
                details: [{
                    "name": "",
                    "data_type":"",
                    "value": []
                }],
                active:"",
                u_name:"",
                u_pass:"",
                loader : false
            };
        },
        methods:{
            check_data_type: function(i){
                if(this.details[i]['value']!="")
                {
                    this.details[i]['value'].push({
                        "value":""
                    });
                }
            },
            add_detail: function(){
                this.details.push({
                    "name": "",
                    "data_type":"",
                    "value": []
                });
            },
            add_detail1: function(key,i){
                this.details[i]['value'].push({
                    "value": "",
                });
            },
            delete_detail: function(vi){
                this.details.splice(vi,1);
            },
            delete_detail1: function(vi){
                this.details.splice(vi,1);
            },
            validation: function(){
                    this.error = {};
               this.details.forEach((item, index) => {
                    if (!item.name) {
                        this.error[`name_${index}`] = "Please enter a name for Field " + (index + 1);
                    }

                    if (!item.data_type) {
                        this.error[`data_type_${index}`] = "Please select a data type for Field " + (index + 1);
                    }

                    if (item.data_type == 4) {
                        item.value.forEach((val, j) => {
                            if (!val.value) {
                                this.error[`value_${index}_${j}`] = "Please enter value for Field " + (index + 1) + ", Array item " + (j + 1);
                            }
                        });
                    } else {
                        if (!item.value) {
                            this.error[`value_${index}`] = "Please enter value for Field " + (index + 1);
                        }
                    }
                });
               console.log(this.error);
                if(Object.keys(this.error).length === 0){
                    const result = {};

                    Object.keys(this.details).forEach(key => {
                        const item = this.details[key];
                        if (item.data_type) {
                            if (item.data_type === "2") {
                                result[item.name] = parseInt(item.value, 10);
                            } else {
                                result[item.name] = item.value;
                            }
                        } else {
                            result[key] = item;
                        }
                    });
                    var postData = {
                        details: result,
                        username: this.u_name,
                        password: this.u_pass,
                        path:this.active,
                        action: "submit"
                    };

                    axios.post("screen_1_control.php",postData).then(response=>{
                        if(response.data.status == "success"){
                             window.location.href = 'congratulations.php';
                        }
                    })
                }
            }
        }
     }).mount("#app");
</script>