<div id="popupreportcomment" class="popup">
    <div class="popupL1"></div>
    <div class="popupM1">
        <div class="popupT1"></div>
        <div class="popupM2">

            <div class="popupL2"></div>
            <div class="popupM3">
                <div class="popupT2">
                    <label class="reporttitle titlesize">Report comment</label>
                </div>
                <div class="popupM4">
                    <div class="inputrow">
                        <label class="labelinput">Report type</label>
                        <select name="report_type" class="comment_report_input">
                            <option selected value="Harassment">Harassment</option>
                            <option value="Hate speech">Hate speech</option>
                            <option value="Encouraging violence">Encouraging violence</option>
                        </select>
                    </div>
                    <div class="linebreak"></div>
                    <label class="labelinput">Explanation</label>
                    <div class="inputarea">
                        <textarea class="generic comment_report_input" rows="3" name="explanation"></textarea>
                    </div>
                </div>
                <div class="popupB2">
                    <div id="inputrow" class="floatright">
                        <button class="svgbutton floatright" onclick="reportComment()">Report</button>
                        <button class="svgbutton floatright" onclick="unloadPopup('popupreportcomment')">Back</button>
                    </div>
                </div>
            </div>
            <div class="popupR2"></div>
        </div>
        <div class="popupB1"></div>
    </div>
    <div class="popupR1"></div>
</div>