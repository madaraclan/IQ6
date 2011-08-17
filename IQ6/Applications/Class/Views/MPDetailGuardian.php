<div>
    Name :
    <?php
        echo $detailMP->SubjectTitle;
    ?>
    <br>
        Objective:
    <?php
        echo $detailMP->Objectives;
    ?>
    <br>
        Material Composition:
    <?php
        echo $detailMP->MaterialComposition;
    ?>
    <br>
        Study Activity:
    <?php
        echo $detailMP->StudyActivity;
    ?>
    <br>
        Task And Evaluation:
    <?php
        echo $detailMP->TaskAndEvaluation;
    ?>
            <br>
            <br>
    <?php
    foreach($detailTask as $taskItem)
    {
        echo $taskItem->TStatus;
        ?>
            : <?php echo $taskItem->TName; ?>
            <br>
            Description:<?php echo $taskItem->TDesc; ?>
            <br>
            Download:<?php echo $taskItem->TFilePath; ?>
            <br>
            <br>
        <?php
    }
    ?>
</div>