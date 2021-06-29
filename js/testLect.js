// let fich = "http://localhost/blog_nader/video/Discours complet du president.mp4"
let deb = 0
let taille = 1024 * 1024 * 8
let vidObj = new Blob()
let pauseAuto = false
// let mimeCodec = 'video/mp4;';
// let sourceBuffer = vidObj.addSourceBuffer(mimeCodec);
let dataCpt = 0
let largeur = parseInt(window.screen.width * 0.8)

// let largeur = (document.getElementById('detArticle').clientWidth * 0.8)



let intDraw = 0
let laVid = document.createElement('video')
// laVid.addEventListener('error', function (err) {
//     // This craps out in Safari 6
//     let errDoc = document.createElement('div')
//     errDoc.innerHTML = JSON.stringify(err, ["message", "arguments", "type", "name"])
//     document.getElementById("detArticle").appendChild(errDoc)
// });



let cnv = document.getElementById("vid");
cnv.width = "" + largeur
cnv.height = "" + parseInt(largeur * 9 / 16)

let fich = cnv.dataset.vid

ctx = cnv.getContext("2d");
window.addEventListener('load', () => {
    largeur = (document.getElementById('detArticle').clientWidth * 0.9)
    cnv.width = "" + largeur
    cnv.height = "" + parseInt(largeur * 9 / 16)

    laVid.width = "" + largeur
    laVid.height = "" + (largeur * 9 / 16)
    laVid.muted = true
    laVid.playsinline = true
    laVid.controls = true
    laVid.style.display = "none"

    document.body.append(laVid)

    ctx.drawImage(document.getElementById("imgLogo"), 0, 0, largeur, (largeur * 9 / 16))

    getPartVid(deb, taille, vidObj)
    // ctx.drawImage(document.getElementById("imgLogo"), 0, 0, 800, 600)
    affControls()
})
window.addEventListener('resize', () => {
    console.log('resize')
    largeur = (document.getElementById('detArticle').clientWidth * 0.9)
    cnv.width = "" + largeur
    cnv.height = "" + parseInt(largeur * 9 / 16)
    affControls()
})


function affControls() {
    if (document.getElementById("contVid") != null) {
        document.getElementById("contVid").parentElement.removeChild(document.getElementById("contVid"))
    }
    let cont = document.createElement('div')
    cont.id = "contVid"
    cont.style.width = largeur + "px"
    cont.style.height = "30px"
    cont.style.backgroundColor = "#EBEBEB"
    cont.style.display = "flex"
    cont.style.justifyContent = "space-around"
    cont.style.alignItems = "center"

    let playBout = document.createElement("i")
    playBout.classList.add("fas", "fa-play")
    playBout.style.color = "blue"
    playBout.addEventListener('mouseover', () => {
        playBout.style.cursor = 'pointer'
    })
    playBout.addEventListener('mouseleave', () => {
        playBout.style.cursor = 'default'
    })
    playBout.addEventListener('click', () => {
        if (!laVid.paused) {
            laVid.pause()
            // affImg()
            clearInterval(intDraw)
            playBout.classList.remove("fa-pause")
            playBout.classList.add("fa-play")
        }
        else {
            laVid.play()
            pauseAuto = false
            // affImg()
            intDraw = setInterval(affImg, 16)
            playBout.classList.add("fa-pause")
            playBout.classList.remove("fa-play")
        }
    })


    let muteBout = document.createElement("i")
    muteBout.classList.add("fas", "fa-volume-mute")
    muteBout.style.color = "blue"
    muteBout.addEventListener('mouseover', () => {
        muteBout.style.cursor = 'pointer'
    })
    muteBout.addEventListener('mouseleave', () => {
        muteBout.style.cursor = 'default'
    })
    muteBout.addEventListener('click', () => {
        if (!laVid.muted) {
            laVid.muted = true
            muteBout.classList.remove("fa-volume-up")
            muteBout.classList.add("fa-volume-mute")
        }
        else {
            laVid.muted = false
            laVid.volume = 1
            intDraw = setInterval(affImg, 16)
            muteBout.classList.add("fa-volume-up")
            muteBout.classList.remove("fa-volume-mute")
        }
    })


    let enCours = document.createElement('div')
    enCours.style.color = "blue"
    enCours.innerHTML = "En cours : "

    let buff = document.createElement('div')
    buff.style.color = "blue"
    buff.innerHTML = "Chargée : "

    let duree = document.createElement('div')
    duree.style.color = "blue"
    duree.innerHTML = "Total : "

    setInterval(() => {
        enCours.innerHTML = "En cours : " + ("00" + parseInt(laVid.currentTime / 60).toString()).slice(-2) + ":" + ("00" + parseInt(laVid.currentTime % 60).toString()).slice(-2)
        if (!isNaN(parseInt(laVid.duration / 60))) {
            duree.innerHTML = "Total : " + ("00" + parseInt(laVid.duration / 60).toString()).slice(-2) + ":" + ("00" + parseInt(laVid.duration % 60).toString()).slice(-2)
        }
        // console.log(laVid.buffered.end(0))
        if (laVid.buffered.length > 0 && !isNaN(parseInt(laVid.buffered.end(laVid.buffered.length - 1) / 60))) {
            buff.innerHTML = "Chargée : " + ("00" + parseInt(laVid.buffered.end(laVid.buffered.length - 1) / 60).toString()).slice(-2) + ":" + ("00" + parseInt(laVid.buffered.end(laVid.buffered.length - 1) % 60).toString()).slice(-2)
        }
        if (laVid.buffered.length > 0 && !isNaN(parseInt(laVid.buffered.end(laVid.buffered.length - 1) / 60))) {
            if ((laVid.buffered.end(laVid.buffered.length - 1) - laVid.currentTime) < 10 && !pauseAuto && (parseInt(laVid.buffered.end(laVid.buffered.length - 1)) != parseInt(laVid.duration))) {
                pauseAuto = true
                playBout.classList.remove("fa-pause")
                playBout.classList.add("fa-play")
                laVid.pause()
            }
            else if ((((laVid.buffered.end(laVid.buffered.length - 1) - laVid.currentTime) > 20) || (parseInt(laVid.buffered.end(laVid.buffered.length - 1)) == parseInt(laVid.duration))) && pauseAuto) {
                pauseAuto = false
                playBout.classList.add("fa-pause")
                playBout.classList.remove("fa-play")
                laVid.play()
            }
        }
    }, 1000)

    cont.appendChild(playBout)
    cont.appendChild(muteBout)
    cont.appendChild(enCours)
    cont.appendChild(buff)
    cont.appendChild(duree)

    document.getElementById("detArticle").appendChild(cont)
}
function affImg() {
    if (!laVid.paused) {
        ctx.drawImage(laVid, 0, 0, parseInt(+largeur), parseInt(+largeur * 9 / (16)))
    }
    // else {
    //     ctx.drawImage(document.getElementById("imgLogo"), 0, 0, parseInt(+largeur), parseInt(+largeur * 9 / 16))
    // }
}
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
    // console.log(deb, taille, obj, fich)
    fetch(fich, myInit).then((response) => {
        return response.blob();
    }).then((data) => {
        // buff.appendBuffer(data)
        // console.log(obj, data, data.size)
        dataCpt++
        obj.arrayBuffer().then(array1 => {
            data.arrayBuffer().then(array2 => {
                obj = new Blob([array1, array2], { type: data.type })
                deb += (taille + 1)
                // && data.size < (400 * 1024 * 1024)
                setTimeout(() => {
                    if (data.size == (taille + 1)) {
                        getPartVid(deb, taille, obj)
                        if (dataCpt > 5) {
                            lectureVid(obj)
                            dataCpt = 0
                        }
                    }
                    else {
                        lectureVid(obj)
                    }

                }, 100)



            })
        })

        // obj += data

    }).catch(err => console.error(err))
}

function lectureVid(obj) {
    let enCours = 0
    let bPause = true
    if (laVid.src !== undefined)
        bPause = laVid.paused
    // mavid.stop()

    if (intDraw != 0) {
        enCours = laVid.currentTime
        clearInterval(intDraw)
        laVid.pause()
    }
    // let objVid = URL.createObjectURL(new File([obj], 'video'))
    let objVid = URL.createObjectURL(obj)
    laVid.src = objVid
    // let reader = new FileReader()
    // reader.readAsDataURL(obj)
    // reader.onload = () => {
    // laVid.src = reader.result
    // laVid.innerHTML = ""
    // let elemSource = document.createElement("source")
    // elemSource.type = "video/mp4"
    // elemSource.src = reader.result
    // laVid.appendChild(elemSource)
    if (enCours != 0)
        laVid.currentTime = enCours
    if (!bPause) {
        laVid.play()
        // affImg()
        intDraw = setInterval(affImg, 16)
    }
    // }

}