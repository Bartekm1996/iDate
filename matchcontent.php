
    <div id="matcharea" class="center mt-lg-2" hidden>
        <div class="card shadow-lg p-3 mb-5 bg-white rounded" style="height: 75vh; width: 22rem; margin-left: auto;margin-right: auto">
            <div style="position:relative">
                <img id="imgP" width="200px" height="250px" src="https://placekitten.com/200/250" class="card-img-top">
                <div class="matchbtn" style="left:2%">
                    <i class="fa fa-3x fa-arrow-circle-left" onclick="prevImg()"></i>
                </div>
                <div class="matchbtn" style="right:2%">
                    <i class="fa fa-3x fa-arrow-circle-right" onclick="nextImg()"></i>
                </div>

            </div>

            <div class="card-body">
                <div class="heartbtn" style="position:relative;left: 35%;">
                    <i class="fa fa-4x fa-ban" style="color: rgba(14,0,6,0.87);" onclick="nomatch()"></i>
                    <i class="fa fa-4x fa-heart" style="color: red;" onclick="match()"></i>
                </div>
                <h5 class="card-title"><b id="uname">Sally</b> <e id="uage">23</e></h5>
                <h6><i class="fa fa-graduation-cap"></i> University Of Limerick</h6>
                <h6><i class="fa fa-suitcase"></i> Software Developer</h6>
                <h6><i class="fa fa-map-marker"></i> Co. Limerick</h6>
            </div>
        </div>
    </div>