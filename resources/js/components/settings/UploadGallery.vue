<template>
    <div class="upload-gallery">
        <v-container>

            <div class="uploader"
                @dragenter="onDragEnter"
                @dragleave="onDragLeave"
                @dragover.prevent
                @drop="onDrop"
                :class="{ dragging: isDragging }"
            >
                <div class="upload-control" v-show="images.length">
                    <label for="profilepicture">Select a file</label>
                    <button @click="upload">Upload</button>
                </div>

                <div v-show="!images.length">
                    <i class="material-icons">backup</i>
                    <p>Drag your image here.</p>
                    <div>OR</div>

                    <div class="file-input-field">
                        <label for="profilepicture">Select a file</label>
                        <input type="file" id="profilepicture" @change="onInputChange">
                    </div>
                </div>

                <div class="preview-image" v-show="images.length" >
                    <div class="image-wrapper" v-for="(image, index) in images" :key="index">
                        <img :src="image" :alt="`Image uploader ${index}`">
                        <div class="details">
                            <span class="text-truncate" v-text="files[index].name"></span>
                            <span v-text="getFileSize(files[index].size)"></span>
                        </div>
                    </div>
                </div>

            </div>


        </v-container>
    </div>
</template>

<script>
export default {
    data() {
        return {
            isDragging: false,
            dragCount: 0,
            files: [],
            images: []
        }
    },
    methods: {
        onDragEnter(e) {
            e.preventDefault()
            this.dragCount++
            this.isDragging = true
        },
        onDragLeave(e) {
            e.preventDefault()
            this.dragCount--

            if (this.dragCount <= 0) {

                this.isDragging = false
            }
        },
        onInputChange(e) {
            const files = e.target.files

            Array.from(files).forEach( (file) => this.addImage(file))
            
        },
        onDrop(e) {
            e.preventDefault()
            e.stopPropagation()

            this.isDragging = false

            const files = e.dataTransfer.files

            Array.from(files).forEach( (file) => this.addImage(file))
        },
        addImage(file) {

            if(!file.type.match('image.*')) {
                console.log(`${file.name} is not a image`);
                return;
            }
            
            this.files.push(file);

            const reader = new FileReader()

            reader.onload = (e) => this.images.push(e.target.result)

            reader.readAsDataURL(file)
        },
        getFileSize(size) {
            var i = Math.floor( Math.log(size) / Math.log(1024) );
            return ( size / Math.pow(1024, i) ).toFixed(2) * 1 + ' ' + ['B', 'kB', 'MB', 'GB', 'TB'][i];
        },

        upload() {
            const formData = new FormData()

            this.files.forEach( (file) => {
                formData.append('images[]', file, file.name)
            })

            // axios.post('/settings-upload', formData)
            //     .then( (response) => {
            //         console.log(response.data)

            //         this.images = [];
            //         this.files = [];
            //     })
            //     .catch( (error) => {
            //         console.log(error);
            //     });
        }
    }
}
</script>

<style lang="scss" scoped>
    .uploader {
        background-color: teal;
        color: white;
        text-align: center;
        padding: 30px 15px;
        border: 1px dotted white;
        font-size: 22px;
        border-radius: 3px;
        position: relative;

        &.dragging {
            border: 1px dotted teal;
            background-color: white;
            color: teal;

            .file-input-field label {
                background-color: teal;
                color: white;
            }
        }

        i {
            font-size: 64px;
        }

        .file-input-field {
            position: relative;
            margin: auto;
            width: 165px;
            height: 50px;
            font-size: 18px;
            margin-top: 10px;

            label,
            input {
                background-color: white;
                color: teal;
                width: 100%;
                padding: 10px;
                position: absolute;
                left: 0;
                top: 0;
                cursor: pointer;
                outline: none;
            }

            input {
                opacity: 0;
                z-index: -99;
            }
        }
    }
    .preview-image {
        display: flex;
        flex-wrap: wrap;
        margin-top: 20px;
        justify-content: center;

        .image-wrapper {
            width: 160px;
            display: flex;
            flex-direction: column;
            margin: 10px;
            height: 150px;
            justify-content: space-between;
            background-color: white;
            box-shadow: 3px 3px 3px #3e3737;

            img{
                max-height: 105px;
            }
        }

        .details {
            font-size: 12px;
            background-color: white;
            color: #222;
            display: grid;
            flex-direction: column;
            align-items: self-start;
            padding: 3px 6px;
        }
    }
    .upload-control {
        

        button, label {
            background-color: white;
            color: #258080;
            font-size: 16px;
            padding: 8px;
            display: inline-block;
            width: 120px;
            margin-bottom: 5px;
            cursor: pointer;
            outline: none;
        }
    }
</style>

