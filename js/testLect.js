// let fich = "http://localhost/blog_nader/video/Discours complet du president.mp4"

let deb = 0
let taille = 2048 * 1024 * 4
let vidObj = new Blob()

// getPartVid(deb, taille, vidObj)
function getPartVid(deb, taille, obj) {
    var myHeaders = new Headers();
    myHeaders.set('Range', "bytes=" + deb + "-" + (deb + taille))

    var myInit = {
        method: 'GET',
        headers: myHeaders,
        mode: 'cors',
        cache: 'default'
    };

    fetch(fich, myInit).then((response) => {
        return response.blob();
    }).then((data) => {
        console.log(obj, data, data.size)
        obj.arrayBuffer().then(array1 => {
            data.arrayBuffer().then(array2 => {
                obj = new Blob([array1, array2], { type: data.type })
                deb += (taille + 1)
                if (data.size == (taille + 1)) {
                    // && data.size < (400 * 1024 * 1024)
                    getPartVid(deb, taille, obj)
                    //    lectureVid(obj)
                }
                else {
                    lectureVid(obj)
                }
            })
        })

        // obj += data

    })
}

function lectureVid(obj) {
    // let mavid = document.getElementById('vid')
    // let objVid = URL.createObjectURL(obj)
    // mavid.src = objVid
    //mavid.play()
}