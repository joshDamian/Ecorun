<notifcations-workflow>
    Questions:
        -Should the notification be profile or user based?
        -How would the display trigger for the notifications fit into the current design.
        -What channel would echo listen on for the notifications... dependent on question 1.
    End_Questions

    PosibleSolutions:
        For_question_1:
            -The notifications can be based on the currently authenticated user and switchable options be provided to view notifications for his/her associated profiles with the default profile as the user's currentProfile.
        End_For_question_1

        For_question_2:
            -The notifications system can be built into a livewire component with triggers calling a function to load notifications... This trigger is called by default on
    End_PossibleSolutions

</notifications-workflow>
