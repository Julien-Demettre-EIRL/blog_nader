window.addEventListener('load', () => {
    let reader = {};
    let file = {};
    let nomVid = document.querySelector('#nomVid')
    let descVid = document.querySelector('#descVid')
    let imgVid = {}
    let slice_size = 100 * 1024; // Taille de chaque segment

    function start_upload(event) {
        event.preventDefault();

        reader = new FileReader();
        file = document.querySelector('#file-input').files[0];
        imgVid = document.querySelector('#imgVid').files[0];

        upload_file(0, 0);
    }

    document.querySelector('#submit-button').addEventListener('click', start_upload);

    function upload_file(start, num) {
        console.log('upload en cours ' + start)
        let next_slice = start + slice_size + 1;
        let blob = file.slice(start, next_slice); // on ne voudra lire qu'un segment du fichier

        reader.onloadend = (event) => { // fonction à exécuter lorsque le segment a fini d'être lu
            if (event.target.readyState !== FileReader.DONE) {
                return;
            }
            let myData = new FormData()
            myData.append('file_data', event.target.result)
            myData.append('file', file.name)
            myData.append('nChunck', num)
            num++
            fetch("./index.php?controller=dashboard&action=upVid", {
                method: "POST",
                body: myData
            }).then((data) => {
                var size_done = start + slice_size;
                var percent_done = Math.floor((size_done / file.size) * 100);

                if (next_slice < file.size) {
                    document.querySelector('#upload-progress').innerHTML = 'Upload en cours - ' + percent_done + '%';

                    upload_file(next_slice, num); // s'il reste à lire, on appelle récursivement la fonction
                } else {
                    document.querySelector('#upload-progress').innerHTML = 'Upload terminé !';
                    //       location.reload()
                    // let reader2 = new FileReader()
                    // reader2.readAsBinaryString(file)
                    // reader2.onload = (e) => {
                    let myData2 = new FormData()
                    myData2.append('videoName', file.name)
                    myData2.append('titre', nomVid.value)
                    myData2.append('description', descVid.value)
                    // myData2.append('img-data', e.target.result)
                    // myData2.append('img-nom', imgVid.name)
                    myData2.append('monimg', imgVid)
                    fetch("./index.php?controller=dashboard&action=insVid", {
                        method: "POST",
                        body: myData2
                    }).then((data) => {
                        // console.log(data.text())
                        window.location = "./index.php?controller=dashboard&action=video"
                    })
                    // }
                }
            }).catch((err) => {
                console.log(err)
            })

        };

        reader.readAsDataURL(blob); // lecture du segment
    }
})